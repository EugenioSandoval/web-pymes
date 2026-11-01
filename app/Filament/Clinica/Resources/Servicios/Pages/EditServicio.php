<?php

namespace App\Filament\Clinica\Resources\Servicios\Pages;

use App\Filament\Clinica\Resources\Servicios\ServicioResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditServicio extends EditRecord
{
    protected static string $resource = ServicioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
