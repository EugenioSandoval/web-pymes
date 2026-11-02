<?php

namespace App\Filament\Clinica\Widgets;

use App\Filament\Clinica\Resources\Citas\CitaResource;
use App\Models\Cita;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class ProximasCitas extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Próximas citas';

    public function table(Table $table): Table
    {
        return $table
            ->query(Cita::query()->activas()->where('inicio', '>=', now())->with(['paciente', 'profesional', 'servicio'])->orderBy('inicio')->limit(8))
            ->paginated(false)
            ->columns([
                TextColumn::make('inicio')->label('Fecha')->dateTime('D d/m · H:i'),
                TextColumn::make('paciente.nombre')->label('Paciente'),
                TextColumn::make('servicio.nombre')->label('Servicio'),
                TextColumn::make('profesional.nombre')->label('Profesional'),
                TextColumn::make('estado')->badge()
                    ->formatStateUsing(fn (string $state) => Cita::ESTADOS[$state] ?? $state)
                    ->color(fn (string $state) => CitaResource::COLORES[$state] ?? 'gray'),
            ])
            ->recordUrl(fn (Cita $record) => CitaResource::getUrl('edit', ['record' => $record]));
    }
}
