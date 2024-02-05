<?php

namespace App\Filament\Exports;

use App\Models\Catalog\Products;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Products::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('slug')
                ->label('Slug'),
            ExportColumn::make('brands.name')
                ->label('Brand'),
            ExportColumn::make('category.name')
                ->label('Category'),
            ExportColumn::make('price'),
            ExportColumn::make('qty')
                ->label('Stock'),
            ExportColumn::make('units.alias')
                ->label('Unit'),
            ExportColumn::make('discount')
                ->label('Discount'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your product export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
