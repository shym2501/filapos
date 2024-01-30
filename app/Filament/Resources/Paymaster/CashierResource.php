<?php

namespace App\Filament\Resources\Paymaster;

use App\Filament\Resources\Paymaster\CashierResource\Pages;
use App\Filament\Resources\Paymaster\CashierResource\RelationManagers;
use App\Models\Paymaster\Cashier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CashierResource extends Resource
{
    protected static ?string $model = Cashier::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'Paymaster';
    protected static ?string $navigationLabel = 'Cashier';
    protected static ?int $navigationGroupSort = 2;
    protected static ?int $navigationSort = 1;

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
            'index' => Pages\ManageCashiers::route('/'),
        ];
    }
}
