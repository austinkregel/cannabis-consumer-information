<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelFollow\Traits\Followable;
use Spatie\Activitylog\Traits\CausesActivity;

class Recall extends Model
{
    use HasFactory, CausesActivity, Followable, Favoriteable;

    public $fillable = [
        'mra_public_notice_url',
        'published_at',
        'user_id',
        'name',
        'original_name',
    ];

    public $dates = ['published_at'];

    public $appends = ['pretty_published_at'];

    public function getPrettyPublishedAtAttribute()
    {
        if (empty($this->published_at)) {
            return null;
        }

        return Carbon::parse($this->published_at)->format('F j, Y H:i a');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'recalled_products');
    }

    public function dispensaries()
    {
        return $this->belongsToMany(Dispensary::class, 'recalled_dispensaries');
    }
}
