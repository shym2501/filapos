<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Unit;

class Products extends Model
{
    use HasFactory;
    protected $table = 'product_products';
    protected $guarded = [];
    protected $fillable = [
        'product_category_id',
        'product_brand_id',
        'name',
        'slug',
        'image',
        'price',
        'discount',
        'product_unit_id',
        'qty'
    ];
    public function category() : BelongsTo {
        return $this->belongsTo(Category::class, 'product_category_id', 'id');
    }
    public function brands() : BelongsTo {
        return $this->belongsTo(Brand::class, 'product_brand_id', 'id');
    }
    public function units() : BelongsTo {
        return $this->belongsTo(Unit::class, 'product_unit_id', 'id');
    }
}


