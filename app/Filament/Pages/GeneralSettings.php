<?php

namespace App\Filament\Pages;

use App\Filament\Clusters\CatalogSetup\Resources\CategoryResource;
use App\Filament\Resources\Product\ProductsResource;
use App\Filament\Clusters\CatalogSetup\Resources\CategoryResource\Pages;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Illuminate\Database\Eloquent\Model;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;


class GeneralSettings extends Page
{
  use HasPageSidebar;
  protected static ?string $navigationIcon = 'heroicon-o-document-text';
  protected static ?string $navigationGroup = 'Catalog';
  protected static ?string $title = 'General';
  protected static string $view = 'filament.pages.general-settings';

  // protected static string $resource = ProductsResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ManageCategories::route('/'),
    ];
  }

  public static function sidebar(): FilamentPageSidebar
  {
    return FilamentPageSidebar::make()
      ->topbarNavigation()
      ->setNavigationItems([
        PageNavigationItem::make('General Settings')
          ->translateLabel()
          ->url(GeneralSettings::getUrl())
          ->icon('heroicon-o-cog-6-tooth')
          ->isActiveWhen(function () {
            return request()->routeIs(GeneralSettings::getRouteName());
          })
          ->visible(true),
        PageNavigationItem::make('Admin Panel Settings')
          ->translateLabel()
          ->url(CategoryResource::getUrl())
          ->icon('heroicon-o-cog-6-tooth')
          //   ->isActiveWhen(function () {
          //     return request()->route()->action['as'] == 'filament.catalog-setup.resources.category-resource.pages.manage-categories';
          //   })
          ->visible(true),
        PageNavigationItem::make('Web Settings')
          ->translateLabel()
          ->url(ProductsResource::getUrl())
          ->icon('heroicon-o-cog-6-tooth')
          //   ->isActiveWhen(function () {
          //     return request()->routeIs(UnitResource::getRouteName());
          //   })
          ->visible(true),
      ]);
  }
}
