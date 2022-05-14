<?php

use App\Jobs\FetchMedicalDispensariesJob;
use App\Jobs\FetchRecreationalDispensariesJob;
use App\Jobs\SyncAllRecalledProducts;
use App\Jobs\SyncMichiganRecallsJob;
use Illuminate\Support\Facades\Artisan;

Artisan::command('test3', function() {
    dispatch_sync(new SyncMichiganRecallsJob);
    dispatch_sync(new SyncAllRecalledProducts);
});

Artisan::command('test4', function () {
    dispatch_sync(new FetchRecreationalDispensariesJob);
});
Artisan::command('test5', function () {
    dispatch_sync(new FetchMedicalDispensariesJob);
});