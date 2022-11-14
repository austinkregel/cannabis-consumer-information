<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory, Followable, Likeable, Favoriteable, LogsActivity;

    public $fillable = ['product_id'];

    public function recalls()
    {
        return $this->belongsToMany(Recall::class, 'recalled_products');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $config = new LogOptions;

        return $config;
    }
}
