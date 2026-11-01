<?php

namespace App\Filament\Clinica\Resources\Pacientes\Pages;

use App\Filament\Clinica\Resources\Pacientes\PacienteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPaciente extends EditRecord
{
    protected static string $resource = PacienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
