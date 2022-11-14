<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Strain extends Model
{
    use HasFactory, Likeable, Favoriteable, Followable, LogsActivity;

    public $fillable = [
        'name',
        'slug',
        'based_on_source',
        'photo_url',
        'genetics',
        'aprox_thc',
        'aprox_cbd',
    ];

    public $casts = [
        'genetics' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions 
    {
        $config = new LogOptions;

        return $config;
    }
}
