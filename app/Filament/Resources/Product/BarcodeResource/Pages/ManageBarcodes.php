<?php

namespace App\Filament\Resources\Product\BarcodeResource\Pages;

use App\Filament\Resources\Product\BarcodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBarcodes extends ManageRecords
{
    protected static string $resource = BarcodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
