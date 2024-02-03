<?php

namespace App\Filament\Clusters;

use App\Filament\Clusters\CatalogSetup\Resources\CategoryResource;
use App\Filament\Pages\GeneralSettings;
use App\Filament\Resources\Product\ProductsResource;
use Filament\Clusters\Cluster;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Illuminate\Database\Eloquent\Model;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Pages\Page;

class CatalogSetup extends Cluster
{
    use HasPageSidebar;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Catalog Setup';
    protected static ?string $navigationParentItem = 'Products';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $slug = 'catalog/category';
    protected static ?int $navigationSort = 1;

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
