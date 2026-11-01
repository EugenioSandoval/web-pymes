<?php

namespace App\Filament\Clinica\Resources\Cotizaciones\Pages;

use App\Filament\Clinica\Resources\Cotizaciones\CotizacionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCotizaciones extends ListRecords
{
    protected static string $resource = CotizacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
