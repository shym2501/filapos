<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Product\Products;

class Category extends Model
{
    use HasFactory;
    protected $table = 'product_category';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'parent_id',
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

    public function Product(): HasOne
    {
        return $this->hasOne(Products::class, 'product_category_id', 'id');
    }
}
