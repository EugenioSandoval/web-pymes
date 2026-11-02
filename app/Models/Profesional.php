<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Trabajador del centro que atiende pacientes. */
class Profesional extends Model
{
    protected $table = 'profesionales';

    protected $fillable = ['nombre', 'especialidad', 'email', 'telefono', 'color', 'bio', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'profesional_servicio');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }
}
