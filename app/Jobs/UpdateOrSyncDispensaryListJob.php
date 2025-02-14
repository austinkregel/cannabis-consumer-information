<?php
declare(strict_types=1);
namespace App\Jobs;

use App\Contracts\Services\GoogleMapsGeocodingServiceContract;
use App\Models\Dispensary;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrSyncDispensaryListJob implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(
        public array $dispensary,
    ) {}

public function handle(GoogleMapsGeocodingServiceContract $service)
{
    if ($this->batch()?->cancelled()) {
        return;
    }

    $dispensary = $this->dispensary;
    $dispensary['licensee_name'] = $dispensary['licensee_name'] ?? $dispensary['license_name'] ?? null;
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
        return;
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
            "Educational Research License - License" => 'educational',
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
