<?php

namespace App\Contracts\Services;

use App\Models\Domain\Geocode;

interface GoogleMapsGeocodingServiceContract
{
    public function geocode(string $address): Geocode;
}