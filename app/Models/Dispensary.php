<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Dispensary extends Model
{
    use HasFactory, Followable, Likeable, Favoriteable, LogsActivity;

    protected $fillable = [
        'name',
        'license_number',
        'address',
        'license_expires_at',
        'official_license_type',
        'is_active',
        'email',
        'phone_number',
        'url',
        'license_type',
        'user_id',
        'is_recreational',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'email',
        'url',
        'user_id',
        'phone_number'
    ];

    public $dates = [
        'license_expires_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $config = new LogOptions;

        return $config;
    }

    public function recalls()
    {
        return $this->belongsToMany(Recall::class, 'recalled_dispensaries');
    }
}
