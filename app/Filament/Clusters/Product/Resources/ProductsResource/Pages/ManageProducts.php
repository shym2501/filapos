<?php

namespace App\Filament\Clusters\Product\Resources\ProductsResource\Pages;

use App\Filament\Clusters\Product\Resources\ProductsResource;
use App\Filament\Exports\ProductExporter;
use App\Filament\Imports\ProductImporter;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProducts extends ManageRecords
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(ProductImporter::class)
                ->color('warning')
                ->icon('heroicon-o-arrow-down-tray')
                ->label('Import'),
            Actions\ExportAction::make()
                ->exporter(ProductExporter::class)
                ->color('success')
                ->icon('heroicon-o-arrow-up-tray')
                ->label('Export'),
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Produk";
    }
}
