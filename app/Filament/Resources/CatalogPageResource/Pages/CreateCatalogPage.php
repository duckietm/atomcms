<?php

namespace App\Filament\Resources\CatalogPageResource\Pages;

use App\Filament\Resources\CatalogPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatalogPage extends CreateRecord
{
    protected static string $resource = CatalogPageResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
