<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Product extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationLabel = 'Product';
    protected static ?string $slug = 'catalog';
    protected static ?int $navigationSort = 1;

}
