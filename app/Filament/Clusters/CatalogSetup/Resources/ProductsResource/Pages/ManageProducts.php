<?php

namespace App\Filament\Clusters\CatalogSetup\Resources\ProductsResource\Pages;

use App\Filament\Clusters\CatalogSetup\Resources\ProductsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProducts extends ManageRecords
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Product";
    }
}
