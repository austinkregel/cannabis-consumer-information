<?php

use App\Jobs\FetchRecalledProductsJob;
use App\Jobs\SyncAllRecalledProducts;
use App\Jobs\SyncMichiganRecallsJob;
use App\Models\Recall;
use App\Services\Crawler\PdfCrawler;
use GuzzleHttp\Client;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Spatie\Crawler\Crawler;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('test2', function () {
    /** @var \App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract $s */
    $s = app(\App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract::class);
    $x = $s->getPackageIdsFromPdfFile('./pdf.pdf');
    dd($x);
});

Artisan::command('test3', function() {
    dispatch_sync(new SyncMichiganRecallsJob);
    dispatch_sync(new SyncAllRecalledProducts);
});