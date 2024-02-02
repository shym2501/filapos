<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class CatalogSetup extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationLabel = 'Catalog Setup';
    protected static ?string $slug = 'catalog/category';
    protected static ?int $navigationSort = 1;

}
