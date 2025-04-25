<?php

namespace App\Http\Controllers;
use App\Models\Store;
use Spatie\Browsershot\Browsershot;

class ScraperController extends Controller
{

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
