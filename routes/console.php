<?php

use App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract;
use App\Jobs\FetchMedicalDispensariesJob;
use App\Jobs\FetchRecalledProductsJob;
use App\Jobs\FetchRecreationalDispensariesJob;
use App\Jobs\GeocodeDispensariesJob;
use App\Jobs\SyncAllRecalledProducts;
use App\Jobs\SyncMichiganRecallsJob;
use App\Models\Dispensary;
use App\Models\Recall;
use Illuminate\Support\Facades\Artisan;

Artisan::command('sync-recalls', function () {
    dispatch_sync(new SyncAllRecalledProducts);
    // dispatch_sync(new SyncMichiganRecallsJob);
})->describe('Sync recalls for all dispensaries');

Artisan::command('test', function () {
    $recall = Recall::find(1);

    file_put_contents(storage_path('recall-1.pdf'), file_get_contents($recall->mra_public_notice_url));
    $file = storage_path('recall-1.pdf');

    dd(app(RecallPdfExtractionServiceContract::class)->getAllIdentifiers($file));
});

Artisan::command('geocode', function () {
    dispatch_sync(new GeocodeDispensariesJob);
});

Artisan::command('seed-everything', function() {
    dispatch(new FetchMedicalDispensariesJob);
    dispatch(new FetchRecreationalDispensariesJob);
    // dispatch(new SyncMichiganRecallsJob);
    // dispatch(new SyncAllRecalledProducts);
});

Artisan::command('explore', function () {
    $dispos = Dispensary::with('recalls')->where('name', 'Likely a closed establishment')->whereHas('recalls')->get();


    dd($dispos->map(function ($dispo) {
        return [
            $dispo->license_number,
            $dispo->recalls->pluck('id'),
        ];
    })->toArray());
});