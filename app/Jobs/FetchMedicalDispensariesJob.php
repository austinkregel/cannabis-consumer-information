<?php

namespace App\Jobs;

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

class FetchMedicalDispensariesJob implements ShouldQueue
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
    public function handle()
    {
        $reader = Reader::createFromPath(storage_path('medical-dispensaries.csv'));

        $headers = [];
        $dispensaries = [];
        foreach ($reader as $row) {
            if (empty($headers)) {
                $headers = $row;
                continue;
            }

            $data = array_combine(array_map(fn($header)=> \Illuminate\Support\Str::snake($header), $headers), $row);
            unset($data['']);
            $dispensaries[] = $data;
        }

        foreach ($dispensaries as $dispensary) {
            $dispo = Dispensary::firstWhere('license_number', $dispensary['record_number']);

            if (!$dispo) {
                Dispensary::create([
                    'name' => $dispensary['licensee_name'],
                    'license_number' => $dispensary['record_number'],
                    'address' => $dispensary['address'],
                    'is_active' => $dispensary['status'] === 'Active',
                    'license_expires_at' => Carbon::createFromFormat('m/d/Y', $dispensary['expiration_date']),
                    'official_license_type' => $dispensary['record_type'],
                    'license_type' => $this->filterLicenseType($dispensary['record_type']),
                    'is_recreational' => false,
                ]);
                continue;
            }

            $dispo->update([
                'name' => $dispensary['licensee_name'],
                'license_number' => $dispensary['record_number'],
                'address' => $dispensary['address'],
                'is_active' => $dispensary['status'] === 'Active',
                'license_expires_at' => Carbon::createFromFormat('m/d/Y', $dispensary['expiration_date']),
                'official_license_type' => $dispensary['record_type'],
                'license_type' => $this->filterLicenseType($dispensary['record_type']),
                'is_recreational' => false,
            ]);
        }
    }

    protected function filterLicenseType($licenseType)
    {
        return match ($licenseType) {
            'Entity Prequalification' => 'prequalification',
            'Class A Grower – License', 'Class B Grower – License', 'Grower License – Class C – 1500 Plants – License', 'Class C Grower – License' => 'grower',
            'Processor - License' => 'processor',
            'Provisioning Center - License' => 'provisioning',
            'Individual Prequalification' => 'individual',
            'Safety Compliance - License' => 'compliance',
            'Secure Transporter - License' => 'transporter',
        };
    }
}
