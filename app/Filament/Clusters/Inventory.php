<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Inventory extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Katalog';
    protected static ?string $navigationLabel = 'Inventori';
    protected static ?string $slug = 'inventory';
    protected static ?int $navigationSort = 2;

}
