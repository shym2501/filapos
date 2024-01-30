<?php

namespace App\Filament\Resources\Product;

use App\Filament\Resources\Product\CategoryResource\Pages;
use App\Filament\Resources\Product\CategoryResource\RelationManagers;
use App\Models\Product\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;

class CategoryResource extends Resource
{
  protected static ?string $model = Category::class;
  protected static ?string $navigationIcon = 'heroicon-o-tag';
  protected static ?string $recordTitleAttribute = 'name';
  protected static ?string $navigationGroup = 'Product Management';
  protected static ?string $navigationLabel = 'Category';
  protected static ?int $navigationSort = 1;

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
                  ->unique(Category::class, 'slug', ignoreRecord: true),
              ]),

              Forms\Components\Select::make('parent_id')
              ->label('Parent')
              ->relationship('parent', 'name', fn (Builder $query) => $query->where('parent_id', null))
              ->searchable()
              ->placeholder('Select parent category'),
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')
          ->sortable(),
        TextColumn::make('slug'),
        Tables\Columns\TextColumn::make('parent.name')
          ->label('Parent')
          ->searchable()
          ->sortable(),
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
      ])
      ->emptyStateActions([
        Tables\Actions\CreateAction::make(),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ManageCategories::route('/'),
    ];
  }
}
