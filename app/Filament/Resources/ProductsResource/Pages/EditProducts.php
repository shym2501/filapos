<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use App\Models\Product\Products;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Illuminate\Database\Eloquent\Model;

class EditProducts extends EditRecord
{
    // public Products $record;
    use HasPageSidebar;
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
