<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Product extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Katalog';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?string $slug = 'catalog';
    protected static ?int $navigationSort = 1;

}
