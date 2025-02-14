<?php

namespace App\Jobs;

use App\Contracts\Services\GoogleMapsGeocodingServiceContract;

class GeocodeDispensariesJob
{
    public function handle(GoogleMapsGeocodingServiceContract $geocoding)
    {
        $dispensaries = \App\Models\Dispensary::query()
            ->where('latitude', null)
            ->where('longitude', null)
            ->where('address', '!=', '')
            ->whereNotNull('address')
            ->get();

        info('Geocoding ' . $dispensaries->count() . ' dispensaries');
        foreach ($dispensaries as $dispensary) {
            try {
                $geocode = $geocoding->geocode($dispensary['address']);
                $dispensary->update([
                    'latitude' => $geocode->latitude ?? null,
                    'longitude' => $geocode->longitude ?? null,
                ]);
                info('Geocoded ' . $dispensary->name);
            } catch (\Throwable $e) {
                info('Failed to gecode ' . $dispensary->id, [
                    'address' => $dispensary->address,
                    'exception' => $e,
                ]);
            };
        }
        info('Finished geocoding.');
    }
}
