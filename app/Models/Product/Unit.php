<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Product\Products;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'product_units';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'alias',
        'slug'
    ];

    public function Product(): HasOne
    {
        return $this->hasOne(Products::class, 'product_unit_id', 'id');
    }
}
