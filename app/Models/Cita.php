<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Una hora agendada en el calendario. */
class Cita extends Model
{
    public const ESTADOS = [
        'pendiente' => 'Pendiente',
        'confirmada' => 'Confirmada',
        'atendida' => 'Atendida',
        'cancelada' => 'Cancelada',
    ];

    protected $table = 'citas';

    protected $fillable = ['paciente_id', 'profesional_id', 'servicio_id', 'inicio', 'fin', 'estado', 'origen', 'notas'];

    protected $casts = ['inicio' => 'datetime', 'fin' => 'datetime'];

    protected static function booted(): void
    {
        // La hora de término se calcula según la duración del servicio.
        static::saving(function (Cita $cita) {
            if ($cita->inicio && $cita->servicio_id) {
                $minutos = Servicio::find($cita->servicio_id)?->duracion_minutos ?? 45;
                $cita->fin = $cita->inicio->copy()->addMinutes($minutos);
            }
        });
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function profesional(): BelongsTo
    {
        return $this->belongsTo(Profesional::class);
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }

    /** Citas que ocupan agenda (todas menos las canceladas). */
    public function scopeActivas(Builder $query): void
    {
        $query->where('estado', '!=', 'cancelada');
    }

    /** ¿Choca con otra cita del mismo profesional? */
    public static function hayChoque(int $profesionalId, $inicio, $fin, ?int $excepto = null): bool
    {
        return static::activas()
            ->where('profesional_id', $profesionalId)
            ->when($excepto, fn ($q) => $q->whereKeyNot($excepto))
            ->where('inicio', '<', $fin)
            ->where('fin', '>', $inicio)
            ->exists();
    }
}
