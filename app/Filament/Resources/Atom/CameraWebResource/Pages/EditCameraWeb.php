<?php

namespace App\Filament\Resources\Atom\FotoResource\Pages;

use App\Filament\Resources\Atom\CameraWebResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCameraWeb extends EditRecord
{
    protected static string $resource = CameraWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
