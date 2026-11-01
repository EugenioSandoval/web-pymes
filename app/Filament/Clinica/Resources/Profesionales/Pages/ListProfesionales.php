<?php

namespace App\Filament\Clinica\Resources\Profesionales\Pages;

use App\Filament\Clinica\Resources\Profesionales\ProfesionalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProfesionales extends ListRecords
{
    protected static string $resource = ProfesionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
