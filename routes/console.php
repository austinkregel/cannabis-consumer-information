<?php

use App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract;
use App\Jobs\FetchMedicalDispensariesJob;
use App\Jobs\FetchRecalledProductsJob;
use App\Jobs\FetchRecreationalDispensariesJob;
use App\Jobs\SyncAllRecalledProducts;
use App\Jobs\SyncMichiganRecallsJob;
use App\Models\Recall;
use Illuminate\Support\Facades\Artisan;

Artisan::command('test', function () {
    $recall = Recall::find(1);

    file_put_contents(storage_path('recall-1.pdf'), file_get_contents($recall->mra_public_notice_url));
    $file = storage_path('recall-1.pdf');

    dd(app(RecallPdfExtractionServiceContract::class)->getAllIdentifiers($file));
});

Artisan::command('seed-everything', function() {
    dispatch_sync(new FetchMedicalDispensariesJob);
    dispatch_sync(new FetchRecreationalDispensariesJob);
    dispatch_sync(new SyncMichiganRecallsJob);
    dispatch_sync(new SyncAllRecalledProducts);
});
