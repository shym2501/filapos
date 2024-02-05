<?php

namespace App\Observers;

use App\Models\Catalog\Products;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{

    public function updated(Products $product): void
    {
        if ($product->isDirty('image')) {
            Storage::disk('public')->delete($product->getOriginal('image'));
        }
    }

    public function deleted(Products $product): void
    {
        if (!is_null($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
    }
}
