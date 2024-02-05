<?php

namespace App\Filament\Clusters\Product\Resources;

use App\Filament\Clusters\Product;
use App\Filament\Clusters\Product\Resources\BrandResource\Pages;
use App\Models\Catalog\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Card;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;
use Filament\Pages\SubNavigationPosition;

class BrandResource extends Resource
{
  protected static ?string $model = Brand::class;
  protected static ?string $cluster = Product::class;
  protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';
  protected static ?string $recordTitleAttribute = 'name';
  protected static ?string $navigationLabel = 'Brand';
  protected static ?int $navigationSort = 3;
  protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::TopBar;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Card::make()
          ->schema([
            Forms\Components\Group::make()
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
              ])
              ->columnSpan(['lg' => 1]),

            Forms\Components\Group::make()
              ->schema([
                Forms\Components\FileUpload::make('logo')
                  ->label('Brand Logo')
                  ->image()
                  ->maxSize(2048)
                  ->directory('brand-logo')
                  ->getUploadedFileNameForStorageUsing(
                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                      ->prepend('brand-logo-'),
                  ),
              ])
              ->columnSpan(['lg' => 1]),
          ])
          ->columns(2),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
    ->defaultSort('name')
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
