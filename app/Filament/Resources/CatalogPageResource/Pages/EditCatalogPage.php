<?php

namespace App\Filament\Resources\CatalogPageResource\Pages;

use App\Filament\Resources\CatalogPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatalogPage extends EditRecord
{
    protected static string $resource = CatalogPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
