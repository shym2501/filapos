<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use App\Models\Product\Products;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Pages\Page;


class ListProducts extends ListRecords
{
    // public Products $record;

    // use HasPageSidebar;
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
