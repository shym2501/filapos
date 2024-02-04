<?php

namespace App\Filament\Clusters\CatalogSetup\Resources\ProductsResource\Pages;

use App\Filament\Clusters\CatalogSetup\Resources\ProductsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProducts extends CreateRecord
{
    protected static string $resource = ProductsResource::class;
}
