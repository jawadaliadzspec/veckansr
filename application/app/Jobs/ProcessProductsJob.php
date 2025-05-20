<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $channelId;
    protected $market;
    protected $limit;
    protected $offset;

    /**
     * Create a new job instance.
     */
    public function __construct($channelId,$limit = 900,$offset = 0, $market = 'SE')
    {
        $this->channelId = $channelId;
        $this->market = $market;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiService = app()->make(\App\Services\AddrevenueApiService::class);
        $productHandler = app()->make(\App\Http\Controllers\AddrevenueController::class); // or your controller if logic is there
        $response = $apiService->request(
            endpoint: '/products',
            queryParams: [
                'channelId' => $this->channelId,
                'market' => $this->market,
                'limit' => $this->limit,
                'offset' => $this->offset,
            ],
            method: 'GET',
            body: [],
        );

        if ($response && is_array($response['results'])) {
            foreach ($response['results'] as $product) {
                $productHandler->createDeals($product);
            }
        }
    }
}
