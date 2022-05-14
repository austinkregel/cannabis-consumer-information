<?php

namespace App\Models\Domain;

class Geocode 
{
    public function __construct(
        public float $latitude,
        public float $longitude
    ) {
    }
}