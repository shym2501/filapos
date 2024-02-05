<?php

namespace App\Filament\Clusters\Product\Resources\UnitResource\Pages;

use App\Filament\Clusters\Product\Resources\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUnits extends ManageRecords
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Satuan";
    }
}
