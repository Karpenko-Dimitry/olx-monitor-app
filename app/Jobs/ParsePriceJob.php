<?php

namespace App\Jobs;

use App\Models\PriceEndpoint;
use App\Services\ParseService\ParseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ParsePriceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Collection $endpoints;
    protected ParseService $paseService;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array|int|null $ids)
    {
        $ids = is_array($ids) ? $ids : [$ids];
        $this->endpoints = PriceEndpoint::whereIn('id', $ids)->get();
        $this->paseService = resolve('parse_service');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        foreach ($this->endpoints as $item) {
            $item->updatePrice($this->paseService->parsePrice($item->url));
            sleep(1);
        }
    }
}
