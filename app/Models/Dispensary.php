<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispensary extends Model
{
    use HasFactory;

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
    ];
}
