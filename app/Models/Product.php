<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $fillable = ['id'];

    public function recalls()
    {
        return $this->belongsToMany(Recall::class, 'recalled_products');
    }
}
