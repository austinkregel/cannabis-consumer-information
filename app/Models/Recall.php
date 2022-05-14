<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recall extends Model
{
    use HasFactory;

    public $fillable = [
        'mra_public_notice_url',
        'published_at',
        'user_id',
        'name',
    ];

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
