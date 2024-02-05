<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Catalog\Products;


class Brand extends Model
{
    use HasFactory;
    protected $table = 'product_brands';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'website'
    ];

    public function Product(): HasOne
    {
        return $this->hasOne(Products::class, 'product_brand_id', 'id');
    }
}
