<?php

namespace App\Models;

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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'recalled_products');
    }
}
