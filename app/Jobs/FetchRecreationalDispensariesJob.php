<?php

namespace App\Jobs;

use App\Contracts\Services\GoogleMapsGeocodingService;
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
use League\Csv\Reader;

class FetchRecreationalDispensariesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GoogleMapsGeocodingServiceContract $service)
    {
        $reader = Reader::createFromPath(storage_path('recreation-dispensaries.csv'));

        $headers = [];
        foreach ($reader as $row) {
            if (empty($headers)) {
                $headers = $row;
                continue;
            }

            $dispensary = array_combine(array_map(fn($header)=> \Illuminate\Support\Str::snake($header), $headers), $row);
            unset($dispensary['']);
            $dispo = Dispensary::firstWhere('license_number', $dispensary['record_number']);

            if (!$dispo) {
                if (!empty($dispensary['address'])) {
                    try { 
                        $geocode = $service->geocode($dispensary['address']);
                    } catch (\Throwable $e) {
                        $geocode = null;
                    };
                }

                Dispensary::create([
                    'name' => $dispensary['license_name'],
                    'latitude' => $geocode->latitude ?? null,
                    'longitude' => $geocode->longitude ?? null,
                    'license_number' => $dispensary['record_number'],
                    'address' => empty($dispensary['address'])? null : $dispensary['address'],
                    'is_active' => $dispensary['status'] !== 'Closed',
                    'license_expires_at' => Carbon::createFromFormat('m/d/Y', $dispensary['expiration_date']),
                    'official_license_type' => $dispensary['record_type'],
                    'license_type' => $this->filterLicenseType($dispensary['record_type']),
                    'is_recreational' => true,
                ]);
                continue;
            }

            $dispo->update([
                'name' => $dispensary['license_name'],
                'license_number' => $dispensary['record_number'],
                'address' => empty($dispensary['address'])? null : $dispensary['address'],
                'is_active' => $dispensary['status'] !== 'Closed',
                'license_expires_at' => Carbon::createFromFormat('m/d/Y', $dispensary['expiration_date']),
                'official_license_type' => $dispensary['record_type'],
                'license_type' => $this->filterLicenseType($dispensary['record_type']),
                'is_recreational' => true,
            ]);       
         }
    }

    protected function filterLicenseType($licenseType)
    {
        return match ($licenseType) {
            'Class A Marihuana Grower - License', 'Class B Marihuana Grower - License', 'Class C Marihuana Grower - License', 'Excess Marihuana Grower - License' => 'grower',

            'Adult-Use Entity Registration - License' => 'adult_use_entity',

            'Marihuana Processor - License' => 'processor',
            'Marihuana Event Organizer - License' => 'event',
            'Marihuana Retailer - License' => 'retailer',
            'Marihuana Secure Transporter - License' => 'transporter',
            'Marihuana Microbusiness - License' => 'microbusiness',
            'Temporary Marihuana Event - License' => 'temporary_event',
            'Designated Consumption Establishment - License' => 'consumption',
            'Marihuana Safety Compliance Facility - License' => 'complicance',
            'Sole Proprietor Registration - License' => 'sole_proprietor',
        };
    }
}