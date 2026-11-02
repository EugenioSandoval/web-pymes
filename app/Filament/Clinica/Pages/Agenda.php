<?php

namespace App\Filament\Clinica\Pages;

use App\Filament\Clinica\Resources\Citas\CitaResource;
use App\Models\Cita;
use App\Models\Profesional;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;

/** Calendario semanal de citas, con un color por profesional. */
class Agenda extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Agenda semanal';

    protected static ?string $navigationLabel = 'Agenda';

    protected string $view = 'filament.clinica.agenda';

    public int $semana = 0;

    public ?int $profesional = null;

    public function anterior(): void
    {
        $this->semana--;
    }

    public function siguiente(): void
    {
        $this->semana++;
    }

    public function hoy(): void
    {
        $this->semana = 0;
    }

    protected function getViewData(): array
    {
        $lunes = now()->startOfWeek(Carbon::MONDAY)->addWeeks($this->semana);
        $dias = collect(range(0, 4))->map(fn ($i) => $lunes->copy()->addDays($i)); // lunes a viernes

        $citas = Cita::activas()
            ->with(['paciente', 'profesional', 'servicio'])
            ->whereBetween('inicio', [$lunes, $lunes->copy()->addDays(6)->endOfDay()])
            ->when($this->profesional, fn ($q) => $q->where('profesional_id', $this->profesional))
            ->orderBy('inicio')
            ->get()
            ->groupBy(fn (Cita $c) => $c->inicio->toDateString());

        return [
            'dias' => $dias,
            'citas' => $citas,
            'horaInicio' => 8,
            'horaFin' => 20,
            'profesionales' => $profesionales = Profesional::where('activo', true)->orderBy('nombre')->get(),
            // Con "todos", cada profesional tiene su propia franja dentro del día.
            'carriles' => $this->profesional ? collect([$this->profesional]) : $profesionales->pluck('id'),
            'urlEditar' => fn (Cita $c) => CitaResource::getUrl('edit', ['record' => $c]),
            'urlNueva' => CitaResource::getUrl('create'),
        ];
    }
}
