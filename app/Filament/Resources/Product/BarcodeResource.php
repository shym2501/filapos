<?php

namespace App\Filament\Resources\Product;

use App\Filament\Resources\Product\BarcodeResource\Pages;
use App\Filament\Resources\Product\BarcodeResource\RelationManagers;
use App\Models\Catalog\Barcode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarcodeResource extends Resource
{
    protected static ?string $model = Barcode::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationLabel = 'Barcode';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBarcodes::route('/'),
        ];
    }
}
