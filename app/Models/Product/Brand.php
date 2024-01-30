<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Product\Products;


class Brand extends Model
{
    use HasFactory;

    public function Product(): HasOne
    {
        return $this->hasOne(Products::class, 'product_brand_id', 'id');
    }
}
