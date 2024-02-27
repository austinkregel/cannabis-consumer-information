<?php

use App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract;
use App\Jobs\IngestDispensariesJob;
use App\Jobs\FetchRecalledProductsJob;
use App\Jobs\FetchRecreationalDispensariesJob;
use App\Jobs\GeocodeDispensariesJob;
use App\Jobs\SyncAllRecalledProducts;
use App\Jobs\SyncMichiganRecallsJob;
use App\Models\Dispensary;
use App\Models\Recall;
use App\Models\Strain;
use App\Services\PublicApis\LeaflyService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

Artisan::command('sync-recalls', function () {
    dispatch_sync(new IngestDispensariesJob(
        storage_path('michigan-dispensary-and-license-list.csv')
    ));
})->describe('Sync recalls for all dispensaries');

Artisan::command('make:service-user', function () {
    \App\Models\User::create([
        'name' => 'Michigan Cannabis Club',
        'email' => 'cannabisclub@kregel.email',
        'password' => bcrypt(Str::random(16)),
    ]);
})->describe('Sync recalls for all dispensaries');

Artisan::command('make:admin-user', function () {
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'austinkregel@gmail.com',
        'password' => bcrypt('000000'),
    ]);
})->describe('Sync recalls for all dispensaries');

Artisan::command('test-leafly', function () {
    $service = new LeaflyService(new Client);

    $page = 1;

    do {
        $paginator = $service->findAll(60, $page++);

        foreach ($paginator->items() as $strain) {
            $localStrain = Strain::firstWhere('name', $strain->name);

            if (empty($localStrain)) {
                $localStrain = Strain::create([
                    'name' => $strain->name,
                    'slug' => Str::slug($strain->name),
                ]);
            }

            $cannabinoids = array_filter([$strain->cannabinoids->cbd->percentile25, $strain->cannabinoids->cbd->percentile50, $strain->cannabinoids->cbd->percentile75, ]);
            $cbdAvg = count($cannabinoids) > 0 ? array_sum($cannabinoids) / count($cannabinoids) : 0;

            $cannabinoids = array_filter([$strain->cannabinoids->thc->percentile25, $strain->cannabinoids->thc->percentile50, $strain->cannabinoids->thc->percentile75, ]);
            $thcAvg = count($cannabinoids) > 0 ? array_sum($cannabinoids) / count($cannabinoids) : 0;

            $localStrain->update([
                'based_on_source' => 'https://www.leafly.com/strains/' . $strain->slug,
                'photo_url' => $strain->stockNugImage,
                'genetics' => array_keys((array)$strain->terps),
                'aprox_thc' => $thcAvg,
                'aprox_cbd' => $cbdAvg,
            ]);

            $this->info(sprintf('%s (%s)', $localStrain->name, $localStrain->slug));
        }
    } while ($paginator->hasMorePages());
});

Artisan::command('test', function () {
    // @source https://en.seedfinder.eu/database/strains/alphabetical/
    Strain::truncate()->get();
    $strains = collect(explode("\n", file_get_contents(database_path('seeders/strains.csv'))))->filter()->unique()->values();
    $existingStrains = Strain::query()->pluck('name');

    $diff = $strains->diff($existingStrains);

    $this->info(sprintf('%d new strains', $diff->count()));

    foreach ($diff as $strain) {
        $localStrain = Strain::firstWhere('slug', Str::slug($strain));

        if (empty($localStrain)) {
            $localStrain = Strain::create([
                'name' => $strain,
                'slug' => Str::slug($strain),
            ]);
        }

        $this->info(sprintf('%s (%s)', $localStrain->name, $localStrain->slug));
    }
});

Artisan::command('geocode', function () {
    dispatch_sync(new GeocodeDispensariesJob);
});

Artisan::command('seed-everything', function() {
//    $this->info('Seeding everything');
//    dispatch_sync(new FetchMedicalDispensariesJob);
//    $this->info('Finished Medical, moving to recreational');
//    dispatch_sync(new FetchRecreationalDispensariesJob);
    $this->info('Syncing recall jobs');
    dispatch_sync(new SyncMichiganRecallsJob);
    $this->info('Parsing the PDFs');
    dispatch_sync(new SyncAllRecalledProducts);
    $this->info('Geocoding missed dispensaries');
    dispatch_sync(new GeocodeDispensariesJob);
    $this->info('Done');
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
