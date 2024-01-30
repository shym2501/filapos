<?php

namespace App\Filament\Resources\Product\ProductsResource\Pages;

use App\Filament\Resources\Product\ProductsResource;
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
