<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Un posible cliente que dejó sus datos en el formulario de la página de venta. */
class Lead extends Model
{
    protected $fillable = ['nombre', 'negocio', 'rubro', 'paquete', 'telefono', 'email', 'mensaje'];

    protected $casts = ['contactado' => 'boolean'];
}
