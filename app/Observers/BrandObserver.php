<?php

namespace App\Observers;

use App\Models\Catalog\Brand;
use Illuminate\Support\Facades\Storage;

class BrandObserver
{

    public function updated(Brand $brand): void
    {
        if ($brand->isDirty('logo')) {
            Storage::disk('public')->delete($brand->getOriginal('logo'));
        }
    }

    public function deleted(Brand $brand): void
    {
        if (!is_null($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }
    }
}
