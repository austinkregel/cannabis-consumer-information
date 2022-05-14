<?php

namespace App\Providers;

use App\Services;
use App\Contracts;
use App\Repositories;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        Contracts\Services\Pdf\PdfParserServiceContract::class => Services\Pdf\PdfParserService::class,
        Contracts\Services\Pdf\RecallPdfExtractionServiceContract::class => Services\Pdf\RecallPdfExtractionService::class,
        Contracts\Services\Crawler\CrawlerContract::class => Services\Crawler\PdfCrawler::class,
        Contracts\Repositories\SystemUserRepositoryContract::class => Repositories\SystemUserRepository::class,
        Contracts\Services\GoogleMapsGeocodingServiceContract::class => Services\GoogleMapsGeocodingService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->bindings as $contract => $binding) {
            $this->app->bind($contract, $binding);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
