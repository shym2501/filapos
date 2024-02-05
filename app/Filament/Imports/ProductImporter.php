<?php

namespace App\Filament\Imports;

use App\Models\Catalog\Products;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProductImporter extends Importer
{
    protected static ?string $model = Products::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->example('Kaos Polo')
                ->rules(['required', 'max:255']),
            // ImportColumn::make('product_brand_id')
            //     ->relationship()
            //     ->label('Brand')
            //     ->rules(['required', 'max:32']),
            // ImportColumn::make('product_category_id')
            //     ->relationship()
            //     ->label('Category')
            //     ->rules(['required', 'max:32']),
            // ImportColumn::make('product_unit_id')
            //     ->relationship()
            //     ->label('Unit')
            //     ->rules(['required', 'max:32']),
            ImportColumn::make('qty')
                ->label('Stock')
                ->requiredMapping()
                ->example('15')
                ->rules(['numeric', 'min:0']),
            ImportColumn::make('price')
                ->numeric()
                ->example('200000')
                ->rules(['numeric', 'min:0']),
        ];
    }

    public function resolveRecord(): ?Products
    {
        // return Product::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Products();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
