<?php

namespace App\Filament\Resources\Product;

use App\Filament\Resources\Product\BrandResource\Pages;
use App\Filament\Resources\Product\BrandResource\RelationManagers;
use App\Models\Product\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrandResource extends Resource
{
  protected static ?string $model = Brand::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $recordTitleAttribute = 'name';
  protected static ?string $navigationGroup = 'Product Management';
  protected static ?string $navigationLabel = 'Brands';
  protected static ?int $navigationSort = 2;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Card::make()
          ->schema([
            Forms\Components\Grid::make()
              ->schema([
                Forms\Components\TextInput::make('name')
                  ->required()
                  ->maxLength(255)
                  ->live(onBlur: true)
                  ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                Forms\Components\TextInput::make('slug')
                  ->disabled()
                  ->dehydrated()
                  ->required()
                  ->maxLength(255)
                  ->unique(Brand::class, 'slug', ignoreRecord: true),

                Forms\Components\TextInput::make('website')
                  ->dehydrated()
                  ->maxLength(255),

                Forms\Components\FileUpload::make('logo')
                  ->label('Brand Logo')
                  ->image()
                  ->maxSize(2048)
                  ->directory('brand-logo')
                  ->getUploadedFileNameForStorageUsing(
                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                      ->prepend('brand-logo-'),
                  ),
              ])->columns(2),
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        ImageColumn::make('logo')
          ->square(),
        TextColumn::make('name')
          ->sortable(),
        TextColumn::make('slug'),
        TextColumn::make('website'),
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
      'index' => Pages\ManageBrands::route('/'),
    ];
  }
}
