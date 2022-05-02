<?php

namespace App\Providers;

use App\Contracts\Services\Pdf\PdfParserServiceContract;
use App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract;
use App\Services\Pdf\PdfParserService;
use App\Services\Pdf\RecallPdfExtractionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PdfParserServiceContract::class, PdfParserService::class);

        $this->app->bind(RecallPdfExtractionServiceContract::class, RecallPdfExtractionService::class);
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
