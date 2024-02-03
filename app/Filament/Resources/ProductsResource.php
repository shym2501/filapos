<?php

namespace App\Filament\Resources;

use App\Filament\Pages\GeneralSettings;
use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Models\Product\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Product\Category;
use App\Models\Product\Brand;
use App\Models\Product\Unit;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Pages\Dashboard;
use Illuminate\Database\Eloquent\Model;

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }

    public static function sidebar(Model $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->topbarNavigation()
            ->setNavigationItems([
                PageNavigationItem::make('Dashboard')
                    ->translateLabel()
                    ->url(Dashboard::getUrl())
                    ->icon('heroicon-o-cog-6-tooth')
                    ->isActiveWhen(function () {
                        return request()->routeIs(Dashboard::getRouteName());
                    })
                    ->visible(true),
                PageNavigationItem::make('General Settings')
                    ->translateLabel()
                    ->url(GeneralSettings::getUrl())
                    ->icon('heroicon-o-cog-6-tooth')
                    ->isActiveWhen(function () {
                        return request()->routeIs(GeneralSettings::getRouteName());
                    })
                    ->visible(true),
                // PageNavigationItem::make('User Dashboard')
                //   ->url(function () use ($record) {
                //     return static::getUrl('dashboard', ['record' => $record->id]);
                //   }),
                // PageNavigationItem::make('View User')
                //   ->url(function () use ($record) {
                //     return static::getUrl('view', ['record' => $record->id]);
                //   }),
                PageNavigationItem::make('Edit User')
                    ->url(function () use ($record) {
                        return static::getUrl('edit', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->route()->action['as'] == 'filament.resources.products-resource.pages.edit-products';
                    }),
                // PageNavigationItem::make('Manage User')
                //   ->url(function () use ($record) {
                //     return static::getUrl('manage', ['record' => $record->id]);
                //   }),
                // PageNavigationItem::make('Change Password')
                //   ->url(function () use ($record) {
                //     return static::getUrl('password.change', ['record' => $record->id]);
                //   }),

                // ... more items
            ]);
    }
}
