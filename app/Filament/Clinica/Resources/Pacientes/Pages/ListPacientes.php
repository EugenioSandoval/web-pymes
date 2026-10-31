<?php

namespace App\Filament\Clinica\Resources\Pacientes\Pages;

use App\Filament\Clinica\Resources\Pacientes\PacienteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPacientes extends ListRecords
{
    protected static string $resource = PacienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
