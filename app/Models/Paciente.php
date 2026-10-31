<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Cliente del centro. */
class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = ['nombre', 'rut', 'telefono', 'email', 'fecha_nacimiento', 'prevision', 'notas'];

    protected $casts = ['fecha_nacimiento' => 'date'];

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class);
    }
}
