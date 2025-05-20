<?php

namespace App\Http\Controllers;
use App\Jobs\ProcessProductsJob;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;
use App\Services\AddrevenueApiService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class AddrevenueController extends Controller
{

    protected AddrevenueApiService $apiService;

    public function __construct(AddrevenueApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getAdvertisers()
    {
        $channelId = config('services.addrevenue.channelId');
        $response = $this->apiService->request(
            endpoint: '/advertisers',
            queryParams: ['channelId' => $channelId]
        );
        try {
//            dd($response);
            foreach ($response['results'] as $app) {
                if ($app['relationStatus'] == 'active'){
                    $this->createCategory($app['categoryId']);
                    $exists = Store::where('channelId', $channelId)->where('name',$app['displayName'])->exists();

                    if ($exists) {
                        continue;
                    }
                    $formatted = preg_replace('/([a-z])([A-Z])/', '$1 & $2', $app['categoryId']);
                    $formatted = ucwords($formatted);
                    Store::create([
                        'channelId'     => $channelId ?? null,
                        'channelName'   => 'VeckansE',
                        'status'        => 1,
                        'programId'     => $app['id'],
                        'name'          => $app['displayName'] ?? null,
                        'categoryName'  => $formatted ?? null,
//                        'categoryId'    => $app['categoryId'] ?? null,
                        'image'         => $app['logoImageFilename'],
//                        'productFeedId' => $pfid ?? null,
                    ]);
                }

            }
            return response()->json(['message' => 'Stores synced successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to save stores.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function getCampaigns()
    {
        try {
            $channelId = config('services.addrevenue.channelId');
            $response = $this->apiService->request(
                endpoint: '/campaigns',
                queryParams: ['channelId' => $channelId]
            );
            $stores = Store::where('channelId', $channelId)->get()->keyBy('programId');
            $campaignsProcessed = 0;

            foreach ($response['results'] as $campaign) {
                if (isset($campaign['id']) && isset($stores[$campaign['advertiserId']])) {
                    $store = $stores[$campaign['advertiserId']];
                    // Check if coupon already exists by title and store
                    $exists = Coupon::where('title', $campaign['description'] ?? '')
                                    ->where('store_id', $store->id)
                                    ->exists();
                    if ($exists) {
                        continue;
                    }
                    // Create new coupon
                    $coupon = new Coupon();
                    $coupon->title = $campaign['description'] ?? null;
                    $coupon->description = $campaign['description'] ?? null;

                    // Get category
                    $category = $this->getCategoryId($store, null);
                    $coupon->category()->associate($category);
                    $coupon->store()->associate($store->id);

                    // Map other fields
                    $coupon->link = $campaign['trackingLink'] ?? null;
                    $coupon->code = $campaign['discountCode'] ?? null;
                    $coupon->is_deal = empty($campaign['discountCode']) ? 1 : 0;
                    $coupon->path = preg_replace('/[^a-zA-Z0-9]/', '', $campaign['description'] ?? '');
                    $coupon->status = 1;

                    // Map additional fields if available
                    if (isset($campaign['validFrom'])) {
                        $coupon->start_date = Carbon::parse($campaign['validFrom']);
                    }
                    if (isset($campaign['validTo'])) {
                        $coupon->expire_date = $campaign['validTo'] == '2045-01-01'? null : Carbon::parse($campaign['validTo']);
                    }
                    if (isset($campaign['imageUrl'])) {
                        $coupon->thumnail = $campaign['imageUrl'];
                    }
                    $coupon->save();
                    $campaignsProcessed++;
//                    dd($campaign);
                }
            }

            return response()->json([
                'message' => 'Campaigns synced successfully.',
                'processed' => $campaignsProcessed
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to save campaigns.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function createCategory($cagetoryName)
    {
        $formatted = preg_replace('/([a-z])([A-Z])/', '$1 & $2', $cagetoryName);
        $formatted = ucwords($formatted);
        $category = Category::query()->where('name_en',$formatted)->first();
        if (!$category) {
            $category = new Category();
            $category->name = $formatted;
            $category->name_en = $formatted;
            $category->save();
        }
    }
    public function getProducts()
    {
        $channelId = config('services.addrevenue.channelId');
        $limit = 1000;
        $offset = 0;
        $totalCount = 475;

        do {
            $response = $this->apiService->request(
                endpoint: '/products',
                queryParams: [
                    'channelId' => $channelId,
                    'market' => 'SE',
                    'limit' => $limit,
                    'offset' => $offset,
                ],
                method: 'GET',
                body: [],
            );
//            dd($response);
//            if ($response && is_array($response['results'])) {
//                foreach ($response['results'] as $product) {
//                    $this->createDeals($product);
//                }
//            }
            ProcessProductsJob::dispatch($channelId, $limit, $offset);
            $offset++;
        } while ($offset < $totalCount);
    }


    public function createDeals($product)
    {

        try {

            // Skip if no image link is available
            if (!isset($product['image_link']) || $product['image_link'] === null) {
                return;
            }

            // Use a more efficient query with exists() instead of first()
            if (Coupon::where('sku', $product['sku'])->exists()) {
                return; // Skip if deal already exists
            }

            // Get store by advertiserId - cache this to avoid repeated queries
            $storeId = $this->getStoreId($product['advertiserId']);
            if (!$storeId) {
                return; // Skip if store not found
            }

            $store = Store::find($storeId);
            if (!$store) {
                return; // Skip if store not found
            }
            $discount = 0;
            if (isset($product['price']) && isset($product['sale_price']) &&
                is_numeric($product['price']) && is_numeric($product['sale_price']) &&
                $product['price'] > 0 && $product['price'] != $product['sale_price']) {
                $discount = (($product['price'] - $product['sale_price']) / $product['price']) * 100;
                $discount = round($discount);
            }

            $categoryId = $this->getCategoryId($store, $product['product_type'] ?? null);
            // Create new deal
            $deal = new Coupon();

            // Make sure title exists before using it
            if (isset($product['title'])) {
                $deal->title = $discount > 0 ? 'Upp till '.$discount.'% Rabatter '.$product['title'] : $product['title'];
                $deal->path = preg_replace('/[^a-zA-Z0-9]/', '', $product['title']);
                $deal->productName = $product['title'];
            } else {
                $deal->title = $discount > 0 ? 'Upp till '.$discount.'% Rabatter' : 'Deal';
                $deal->path = 'deal-' . time(); // Fallback path
                $deal->productName = null;
            }

            $deal->description = $product['description'] ?? null;
            $deal->category_id = $categoryId; // Direct assignment is faster than associate()
            $deal->store_id = $storeId; // Direct assignment is faster than associate()
            $deal->link = isset($product['trackingLink']) ? $product['trackingLink'] : ($product['link'] ?? null);
            $deal->is_deal = 1;
            $deal->thumnail = $product['image_link'] ?? null;
            $deal->sku = $product['sku']; // We already checked this exists
            $deal->productPrice = isset($product['sale_price']) ? $product['sale_price'] : ($product['price'] ?? null);
            $deal->oldPrice = $product['price'] ?? null;
            $deal->productUrl = $product['link'] ?? null;
            $deal->status = 1;

            // Use a try-catch block specifically for the save operation
            try {
                $deal->save();
            } catch (\Exception $e) {
                // Log the error but don't throw it to avoid stopping the entire process
                \Log::warning("Failed to save deal with SKU {$product['sku']}: " . $e->getMessage());
            }
        } catch (\Exception $e) {
            // Log the error but don't throw it to avoid stopping the entire process
            \Log::warning("Error processing product: " . $e->getMessage());
        }
    }

    public function getStoreId($programId){
        return Store::query()->where('programId', $programId)->value('id');
    }
    public function getCategoryId($store,$childCategory){
        //dd($store,$childCategory);
        $parentCategory = Category::query()->where('name_en', $store->categoryName)->first();
//        if (!$childCategory){
//            return $parentCategory->id;
//        }
//        $category = Category::query()->where('name_en', $childCategory)->first();
//        if (!$category) {
//            $category = new Category();
//            $category->parent()->associate($parentCategory->id);
//            $category->name = $childCategory;
//            $category->name_en = $childCategory;
//            $category->save();
//        }
        return $parentCategory->id;
    }

}
