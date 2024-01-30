<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product\Product;

class Category extends Model
{
    use HasFactory;
    protected $table = 'product_category';
    protected $fillable = [
        'name',
        'slug'
    ];
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /** @return BelongsTo<Category,self> */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    // public function products(): BelongsToMany
    // {
    //     return $this->belongsToMany(Products::class, 'product_category_products', 'product_category_id', 'product_product_id');
    // }
}
