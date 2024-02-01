<?php

namespace App\Filament\Resources\Stockroom\StockResource\Pages;

use App\Filament\Resources\Stockroom\StockResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStocks extends ManageRecords
{
    protected static string $resource = StockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
