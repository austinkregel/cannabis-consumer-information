<?php

namespace App\Jobs;

use App\Contracts\Repositories\SystemUserRepositoryContract;
use App\Contracts\Services\GoogleMapsGeocodingServiceContract;
use App\Models\Dispensary;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use League\Csv\Reader;

class IngestDispensariesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct (public string $path) {
    }
    public function handle(SystemUserRepositoryContract $systemUserRepository)
    {
        $reader = Reader::createFromPath($this->path);

        $headers = [];
        info('Updating dispensaries');
        $data = [];
        foreach ($reader as $row) {
            if (empty($headers)) {
                $headers = $row;
                info('Found headers', ['headers' => $headers]);
                continue;
            }

            $dispensary = array_combine(array_map(fn($header)=> \Illuminate\Support\Str::snake($header), $headers), $row);
            $data[] = $dispensary;
        }

         Bus::batch(collect($data)
                 ->chunk(50)
                 ->map(fn($chunk) => new UpdateOrSyncDispensaryListJob($chunk->toArray()))
                 ->toArray())
                ->allowFailures()
                ->dispatch();
    }
}
