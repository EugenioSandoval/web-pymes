<?php

namespace App\Filament\Clinica\Resources\Profesionales\Pages;

use App\Filament\Clinica\Resources\Profesionales\ProfesionalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProfesional extends EditRecord
{
    protected static string $resource = ProfesionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
