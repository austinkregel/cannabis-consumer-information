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
use League\Csv\Reader;

class IngestDispensariesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct (public string $path) {
        $this->onQueue('cannabis');
    }
    public function handle(GoogleMapsGeocodingServiceContract $service, SystemUserRepositoryContract $systemUserRepository)
    {
        $systemUser = $systemUserRepository->findOrFail();
        auth()->login($systemUser);

        $reader = Reader::createFromPath($this->path);

        $headers = [];
        info('Updating dispensaries');
        foreach ($reader as $row) {
            if (empty($headers)) {
                $headers = $row;
                info('Found headers', ['headers' => $headers]);
                continue;
            }

            $dispensary = array_combine(array_map(fn($header)=> \Illuminate\Support\Str::snake($header), $headers), $row);
            $dispensary['licensee_name'] = $dispensary['license_name'] ?? null;
            unset($dispensary['']);
            $dispo = Dispensary::firstWhere('license_number', $dispensary['record_number']);

            if (!$dispo) {
                if (!empty($dispensary['address'])) {
                    try {
                        $geocode = $service->geocode($dispensary['address']);
                    } catch (\Throwable $e) {
                        $geocode = null;
                    }
                }
                info('Creating dispensary '.$dispensary['licensee_name'] ?? null, [
                    'record_number' => $dispensary['record_number'],
                    'address' => $dispensary['address'],
                ]);
                Dispensary::create([
                    'name' => $dispensary['licensee_name'] ?? null,
                    'latitude' => $geocode->latitude ?? null,
                    'longitude' => $geocode->longitude ?? null,
                    'license_number' => $dispensary['record_number'],
                    'address' => $dispensary['address'],
                    'is_active' => $dispensary['status'] === 'Active',
                    'license_expires_at' => Carbon::createFromFormat('m/d/Y', $dispensary['expiration_date']),
                    'official_license_type' => $dispensary['record_type'],
                    'license_type' => $this->filterLicenseType($dispensary['record_type']),
                    'is_recreational' => $this->isRecreationalLicense($dispensary['record_type']),
                ]);
                continue;
            }
            if (!empty($dispensary['address'])) {
                try {
                    $geocode = $service->geocode($dispensary['address']);
                } catch (\Throwable $e) {
                    $geocode = null;
                }
            }
            info('Updating dispensary ' . $dispensary['licensee_name'], [
                'record_number' => $dispensary['record_number'],
                'address' => $dispensary['address'],
            ]);

            $dispo->update([
                'name' => $dispensary['licensee_name'],
                'latitude' => $geocode->latitude ?? $dispo->latitude,
                'longitude' => $geocode->longitude ?? $dispo->longitude,
                'license_number' => $dispensary['record_number'],
                'address' => $dispensary['address'],
                'is_active' => $dispensary['status'] === 'Active',
                'license_expires_at' => Carbon::createFromFormat('m/d/Y', $dispensary['expiration_date']),
                'official_license_type' => $dispensary['record_type'],
                'license_type' => $this->filterLicenseType($dispensary['record_type']),
                'is_recreational' => $this->isRecreationalLicense($dispensary['record_type']),
            ]);
        }
        auth()->logout();
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
            'Marihuana Microbusiness - License', 'Class A Marihuana Microbusiness - License' => 'microbusiness',
            'Temporary Marihuana Event - License' => 'temporary_event',
            'Designated Consumption Establishment - License' => 'consumption',
            'Marihuana Safety Compliance Facility - License' => 'compliance',
            'Sole Proprietor Registration - License' => 'sole_proprietor',
            'Entity Prequalification' => 'prequalification',
            'Class A Grower – License', 'Class B Grower – License', 'Grower License – Class C – 1500 Plants – License', 'Class C Grower – License' => 'grower',
            'Processor - License' => 'processor',
            'Provisioning Center - License' => 'provisioning',
            'Individual Prequalification' => 'individual',
            'Safety Compliance - License' => 'compliance',
            'Secure Transporter - License' => 'transporter',
            default => dd($licenseType)
        };
    }

    protected function isRecreationalLicense($licenseType)
    {
        return match ($licenseType) {
            'Entity Prequalification',
            'Class A Grower – License',
            'Class B Grower – License',
            'Grower License – Class C – 1500 Plants – License',
            'Class C Grower – License',
            'Processor - License',
            'Provisioning Center - License',
            'Individual Prequalification',
            'Safety Compliance - License',
            'Secure Transporter - License' => false,
            default => true,
        };
    }
}
