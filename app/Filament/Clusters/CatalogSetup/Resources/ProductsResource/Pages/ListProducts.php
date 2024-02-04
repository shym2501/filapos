<?php

namespace App\Filament\Clusters\CatalogSetup\Resources\ProductsResource\Pages;

use App\Filament\Clusters\CatalogSetup\Resources\ProductsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
