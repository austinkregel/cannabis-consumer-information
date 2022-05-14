<?php

namespace App\Services;

use App\Contracts\Services\GoogleMapsGeocodingServiceContract;
use App\Models\Domain\Geocode;
use GuzzleHttp\Client;

class GoogleMapsGeocodingService implements GoogleMapsGeocodingServiceContract
{
    public function geocode(string $address): Geocode
    {
        $client = new Client(); // GuzzleHttp\Client
        $baseURL = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
        $addressURL = urlencode($address). '&key=' . env('GOOGLE_MAPS_API_KEY');
        $url = $baseURL . $addressURL;
        $response = cache()->remember($address, now()->addDay(), fn () => $client->request('GET', $url)->getBody()->getContents());
        $response = json_decode($response);
        $latitude = $response->results[0]->geometry->location->lat;
        $longitude = $response->results[0]->geometry->location->lng;
    
        return new Geocode($latitude, $longitude);
    }
}