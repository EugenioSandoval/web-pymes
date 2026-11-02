<?php

namespace App\Filament\Clinica\Resources\Cotizaciones\Pages;

use App\Filament\Clinica\Resources\Cotizaciones\CotizacionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCotizacion extends EditRecord
{
    protected static string $resource = CotizacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
