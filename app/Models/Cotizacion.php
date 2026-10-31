<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cotizacion extends Model
{
    public const ESTADOS = [
        'borrador' => 'Borrador',
        'enviada' => 'Enviada',
        'aceptada' => 'Aceptada',
        'rechazada' => 'Rechazada',
    ];

    protected $table = 'cotizaciones';

    protected $fillable = ['numero', 'paciente_id', 'fecha', 'valida_hasta', 'estado', 'descuento_porcentaje', 'observaciones'];

    protected $casts = ['fecha' => 'date', 'valida_hasta' => 'date'];

    protected static function booted(): void
    {
        static::creating(function (Cotizacion $cotizacion) {
            $cotizacion->numero ??= static::siguienteNumero();
        });
    }

    public static function siguienteNumero(): string
    {
        $ultimo = (int) str_replace('COT-', '', (string) static::max('numero'));

        return 'COT-'.str_pad((string) ($ultimo + 1), 4, '0', STR_PAD_LEFT);
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CotizacionItem::class);
    }

    public function subtotal(): int
    {
        return (int) $this->items->sum(fn ($i) => $i->cantidad * $i->precio_unitario);
    }

    public function descuento(): int
    {
        return (int) round($this->subtotal() * $this->descuento_porcentaje / 100);
    }

    public function total(): int
    {
        return $this->subtotal() - $this->descuento();
    }
}
