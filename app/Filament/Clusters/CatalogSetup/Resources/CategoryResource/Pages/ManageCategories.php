<?php

namespace App\Filament\Clusters\CatalogSetup\Resources\CategoryResource\Pages;

use App\Filament\Clusters\CatalogSetup\Resources\CategoryResource;
use App\Filament\Pages\GeneralSettings;
use App\Models\Product\Category;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;

class ManageCategories extends ManageRecords
{
    // use HasPageSidebar;
    protected static string $resource = CategoryResource::class;
    // public Category $record;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTitle(): string
    {
        return "Category";
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
                // PageNavigationItem::make('Web Settings')
                //   ->translateLabel()
                //   ->url(ProductsResource::getUrl())
                //   ->icon('heroicon-o-cog-6-tooth')
                //   //   ->isActiveWhen(function () {
                //   //     return request()->routeIs(UnitResource::getRouteName());
                //   //   })
                //   ->visible(true),
            ]);
    }
}
