<?php

namespace App\Filament\Resources\Product;

use App\Filament\Resources\Product\ProductsResource\Pages;
// use App\Filament\Resources\Product\ProductsResource\RelationManagers;
use App\Filament\Resources\Product\CategoryResource\RelationManagers;
use App\Models\Product\Category;
use App\Models\Product\Brand;
use App\Models\Product\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Imports\ImportColumn;
use Filament\Resources\Forms\Components\Text;


class ProductsResource extends Resource
{
  protected static ?string $model = Products::class;

  protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
  protected static ?string $recordTitleAttribute = 'name';
  protected static ?string $navigationGroup = 'Product Management';
  protected static ?string $navigationLabel = 'Products';
  protected static ?int $navigationSort = 4;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Group::make()
          ->schema([
            Forms\Components\Section::make()
              ->schema([
                Forms\Components\TextInput::make('name')
                  ->required()
                  ->maxLength(255)
                  ->live(onBlur: true)
                  ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                    if ($operation !== 'create') {
                      return;
                    }

                    $set('slug', Str::slug($state));
                  }),

                Forms\Components\TextInput::make('slug')
                  ->disabled()
                  ->dehydrated()
                  ->required()
                  ->maxLength(255)
                  ->unique(Products::class, 'slug', ignoreRecord: true),
              ])
              ->columns(2),

            Forms\Components\Section::make('Associations')
              ->schema([
                Forms\Components\Select::make('product_brand_id')
                  ->label('Select Brand')
                  ->options(Brand::all()->pluck('name', 'id')),

                Forms\Components\Select::make('product_category_id')
                  ->label('Select Category')
                  ->options(Category::all()->pluck('name', 'id'))
                  ->required(),
              ]),

          ])
          ->columnSpan(['lg' => 1]),

        Forms\Components\Group::make()
          ->schema([
            Forms\Components\Section::make('Pricing')
              ->schema([
                Forms\Components\TextInput::make('price')
                  ->numeric()
                  ->rules(['regex:/^\d{1,6}$/'])
                  ->required(),

                Forms\Components\TextInput::make('discount')
                  ->label('Discount')
                  ->numeric()
                  ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
              ])
              ->columns(2),
            Forms\Components\Section::make('Inventory')
              ->schema([
                Forms\Components\TextInput::make('unit_id')
                  ->label('Satuan')
                  ->unique(Products::class, 'unit_id', ignoreRecord: true)
                  ->maxLength(255)
                  ->required(),

                Forms\Components\TextInput::make('qty')
                  ->label('Quantity')
                  ->numeric()
                  ->rules(['integer', 'min:0'])
                  ->required(),
              ])
              ->columns(2),

            Forms\Components\FileUpload::make('image')
              ->label('Product Image')
              ->image()
              ->maxSize(2048)
              ->directory('product')
              ->getUploadedFileNameForStorageUsing(
                fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                  ->prepend('product-'),
              ),
          ])
          ->columnSpan(['lg' => 1]),
      ])
      ->columns(2);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('name')
      ->columns([
        ImageColumn::make('image')
          ->label('Image')
          ->square()
          ->toggleable(),

        Tables\Columns\TextColumn::make('name')
          ->label('Name')
          ->searchable()
          ->sortable(),

        Tables\Columns\TextColumn::make('brands.name')
          ->label('Brand')
          ->searchable()
          ->sortable()
          ->toggleable(),

        Tables\Columns\TextColumn::make('category.name')
          ->label('Category')
          ->searchable()
          ->sortable()
          ->toggleable(),

        Tables\Columns\TextColumn::make('price')
          ->label('Price')
          ->searchable()
          ->sortable()
          ->toggleable(),

        Tables\Columns\TextColumn::make('qty')
          ->label('Quantity')
          ->searchable()
          ->sortable()
          ->toggleable(),
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
      'index' => Pages\ManageProducts::route('/'),
    ];
  }
}
