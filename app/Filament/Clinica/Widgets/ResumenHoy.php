<?php

namespace App\Filament\Clinica\Widgets;

use App\Models\Cita;
use App\Models\Cotizacion;
use App\Models\Paciente;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ResumenHoy extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $hoy = Cita::activas()->whereDate('inicio', today());
        $pendientes = Cita::where('estado', 'pendiente')->where('inicio', '>=', now())->count();
        $web = Cita::where('origen', 'web')->where('created_at', '>=', now()->subDays(7))->count();

        return [
            Stat::make('Citas hoy', (clone $hoy)->count())
                ->description((clone $hoy)->where('estado', 'atendida')->count().' atendidas'),
            Stat::make('Por confirmar', $pendientes)
                ->description('Citas futuras pendientes')
                ->color($pendientes ? 'warning' : 'success'),
            Stat::make('Reservas web (7 días)', $web)->description('Hechas por pacientes desde la web'),
            Stat::make('Pacientes', Paciente::count())
                ->description(Cotizacion::where('estado', 'enviada')->count().' cotizaciones esperando respuesta'),
        ];
    }
}
