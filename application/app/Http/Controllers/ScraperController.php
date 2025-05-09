<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;
use App\Services\AdtractionApiService;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class ScraperController extends Controller
{

    protected AdtractionApiService $apiService;

    public function __construct(AdtractionApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getApplications()
    {
        $channelId = config('services.adtraction.channelId');
        $response = $this->apiService->request(
            endpoint: '/partner/applications/',
            queryParams: ['channelId' => $channelId]
//            queryParams: ['market' => 'SE','programId'=>54505765,'channelId' => $channelId]
        );

        try {
            foreach ($response as $app) {
                if ($app['status']){
                    $this->createCategory($app['programId'],$app['categoryName']);
                    $exists = Store::where('programId', $app['programId'])->exists();

                    if ($exists) {
                        continue;
                    }
                    // Insert new record
                    $programData = $this->apiService->request(
                        endpoint: '/partner/programs/',
                        queryParams: ['market' => 'SE','programId'=>$app['programId'],'channelId' => $channelId]
                    );
                    $pfid = null;
                    if (isset($programData[0]['feedURL'])) {
                        $parts = parse_url($programData[0]['feedURL'] ?? null);
                        parse_str($parts['query'], $queryParams);
                        $pfid = $queryParams['pfid'] ?? null;
                    }

                    Store::create([
                        'channelId'     => $app['channelId'] ?? null,
                        'channelName'   => $app['channelName'] ?? null,
                        'status'        => $app['status'] ?? null,
                        'programId'     => $app['programId'],
                        'name'          => $app['programName'] ?? null,
                        'categoryName'  => $app['categoryName'] ?? null,
                        'categoryId'    => $app['categoryId'] ?? null,
                        'image'         => $programData[0]['logoURL'],
                        'productFeedId' => $pfid ?? null,
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

    public function createCategory($programId,$cagetoryName)
    {
        $category = Category::query()->where('name_en',$cagetoryName)->first();
        if (!$category) {
            $category = new Category();
            $category->name = $cagetoryName;
            $category->name_en = $cagetoryName;
            $category->save();
        }
    }
    public function getProductFeed()
    {
        try {
            ini_set('max_execution_time', 300);
            $stores = Store::query()->whereNotNull('productFeedId')->get();
            $channelId = config('services.adtraction.channelId');
            foreach ($stores as $store) {
                $response = $this->apiService->request(
                    endpoint: '/partner/products/feed/',
                    queryParams: [],
                    method: 'POST',
                    body: [
                        'programId' => $store->programId,
                        'channelId' => $channelId,
                        'feedId'=> $store->productFeedId,
                        'setEpi'    => true,
                        'gt'=>false,
                    ],
                    version: 'v3'
                );
                if ($response){
                    foreach ($response as $product) {
                        $this->createDeals($product,$store->programId,$store);
                    }
                }
            }

//            return response()->json($response);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function createDeals($product,$programId,$store)
    {

        $deal = Coupon::query()->where('sku', $product['sku'])->first();
        if (!$deal) {
            $discount = (($product['oldPrice'] - $product['productPrice']) / $product['oldPrice']) * 100;
            $discount = round($discount);
            $category = $this->getCategoryId($store,$product['productCategory'] ?? null);
            $deal = new Coupon();
            $deal->title = $discount > 0 ? 'Upp till '.$discount.'% Rabatter '.$product['productName'] : $product['productName'];
            $deal->description = $product['productDescription'] ?? null;
            $deal->category()->associate($category);
            $deal->store()->associate($store->id);
            $deal->link = $product['trackingUrl'];
            $deal->is_deal = 1;
            $deal->path = preg_replace('/[^a-zA-Z0-9]/', '', $product['productName']);
            $deal->thumnail = $product['imageUrl'] ?? null;
            $deal->sku = $product['sku'] ?? null;
            $deal->productName = $product['productName'] ?? null;
            $deal->productPrice  = $product['productPrice'] ?? null;
            $deal->oldPrice  = $product['oldPrice'] ?? null;
            $deal->productUrl = $product['productUrl'] ?? null;
            $deal->status = 1;
            $deal->save();
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
    public function saveImageFromUrl($url)
    {
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'] ?? '';
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $safeName = Str::random(20) . ($extension ? ".{$extension}" : '.jpg'); // default to jpg if no extension

        // Download image temporarily
        $imageContents = file_get_contents($url);
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'logo_img_');
        file_put_contents($tmpFilePath, $imageContents);

        // Wrap it into an UploadedFile instance
        $uploadedFile = new \Illuminate\Http\UploadedFile(
            $tmpFilePath,
            basename($url),
            null,
            null,
            true // Test mode for non-user uploads
        );
        return fileUploader($uploadedFile, getFilePath('store'));
    }
    public function scrapeTop20()
    {

        $baseUrl = "https://www.cuponation.se";
        $html = Browsershot::url($baseUrl.'/allabutiker')
            ->waitUntilNetworkIdle()
            ->bodyHtml();
        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $crawler->filter('div[data-testid="alphabet-sections"]')->each(function ($node, $i) {
            $node->filter('ul')->each(function ($node, $i) {
                $node->filter('li')->each(function ($node, $i) {
                    $this->saveStore($node->text());
                });
            });
        });

        return 'Scraping complete.';
    }
    public function saveStore($name){
        $store = Store::query()->where('name', $name)->first();
        if(!$store){
            //create new store
            $store = new Store();
            $store->name = $name;
            $store->status = 2;
            $store->save();
        }
    }
    public function scrapeStoreImage()
    {
        $baseUrl = "https://www.cuponation.se";
        $stores = Store::query()->where('image', null)->get();

        foreach ($stores as $store) {
            $slug = strtolower(str_replace(' ', '-', $store->name));
            $fullUrl = $baseUrl . '/' . $slug . '-rabattkod';

            try {
                $html = Browsershot::url($fullUrl)
                    ->waitUntilNetworkIdle()
                    ->bodyHtml();

                $crawler = new \Symfony\Component\DomCrawler\Crawler($html);

                $crawler->filter('div[data-testid="header-widget"]')->each(function ($node) use ($store, $baseUrl) {
                    $imgNode = $node->filter('img');
                    $storeImage = $imgNode->count() ? $imgNode->attr('src') : null;

                    if ($storeImage) {
                        // Handle relative image paths
                        if (str_starts_with($storeImage, '/')) {
                            $storeImage = $baseUrl . $storeImage;
                        }

                        // Download the image temporarily
                        $imageContents = file_get_contents($storeImage);
                        $tmpFilePath = tempnam(sys_get_temp_dir(), 'store_img_');
                        file_put_contents($tmpFilePath, $imageContents);

                        // Wrap it into an UploadedFile instance
                        $uploadedFile = new \Illuminate\Http\UploadedFile(
                            $tmpFilePath,
                            basename($storeImage),
                            null,
                            null,
                            true // set test mode to true so Laravel won't try to validate it's a real upload
                        );

                        // Save using your fileUploader function
                        $store->image = fileUploader($uploadedFile, getFilePath('store'));
                        $store->save();
                    }
                });

            } catch (\Exception $e) {
                dd("Failed to scrape image for store: {$store->name}. Error: " . $e->getMessage());
            }
        }
    }

}
