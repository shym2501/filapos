<?php

namespace App\Filament\Clusters\CatalogSetup\Resources\BrandResource\Pages;

use App\Filament\Clusters\CatalogSetup\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBrands extends ManageRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
