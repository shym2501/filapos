<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product\Brand;

class Products extends Model
{
    use HasFactory;
    protected $table = 'product_products';
    protected $fillable = [
        'name',
        'slug',
        'price',
        'qty'
    ];

    protected $guarded = [];

    public function category() : BelongsTo {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function brand() : BelongsTo {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    // public function unit() : BelongsTo {
    //     return $this->belongsTo(Unit::class, 'unit_id', 'id');
    // }
}


