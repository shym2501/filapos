<?php

namespace App\Filament\Resources\Paymaster\CashierResource\Pages;

use App\Filament\Resources\Paymaster\CashierResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCashiers extends ManageRecords
{
    protected static string $resource = CashierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
