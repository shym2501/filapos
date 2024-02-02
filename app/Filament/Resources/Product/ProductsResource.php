<?php

namespace App\Filament\Resources\Product;

use App\Filament\Resources\Product\ProductsResource\Pages;
use Filament\Resources\Pages\Page;
use App\Models\Product\Category;
use App\Models\Product\Brand;
use App\Models\Product\Unit;
use App\Models\Product\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Imports\ImportColumn;
use Filament\Resources\Forms\Components\Text;


class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationLabel = 'Products';
    protected static ?int $navigationSort = 2;

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


                        Forms\Components\Select::make('product_brand_id')
                            ->label('Select Brand')
                            ->options(Brand::all()->pluck('name', 'id')),

                        Forms\Components\Select::make('product_category_id')
                            ->label('Select Category')
                            ->options(Category::all()->pluck('name', 'id'))
                            ->required(),

                        Forms\Components\Select::make('product_unit_id')
                            ->label('Select Unit')
                            ->options(Unit::all()->pluck('name', 'id'))
                            ->required(),


                    ])
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}$/'])
                                    ->required(),

                                // Forms\Components\TextInput::make('discount')
                                //     ->label('Discount')
                                //     ->numeric()
                                //     ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),

                                Forms\Components\TextInput::make('qty')
                                    ->label('Stock')
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
                    ->label('Stock')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('units.alias')
                    ->label('Unit')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('discount')
                    ->label('Discount')
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

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ManageProducts::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }

}
