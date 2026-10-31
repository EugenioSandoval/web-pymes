<?php

namespace App\Filament\Clinica\Resources\Citas\Pages;

use App\Filament\Clinica\Resources\Citas\CitaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCitas extends ListRecords
{
    protected static string $resource = CitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
