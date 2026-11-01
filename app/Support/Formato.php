<?php

namespace App\Support;

class Formato
{
    /** 15000 -> "$15.000" */
    public static function clp(int|float|null $monto): string
    {
        return '$'.number_format((float) $monto, 0, ',', '.');
    }

    /** URL de una foto de Pexels por su ID, en el ancho pedido. */
    public static function foto(int $id, int $ancho = 800): string
    {
        return "https://images.pexels.com/photos/{$id}/pexels-photo-{$id}.jpeg?auto=compress&cs=tinysrgb&w={$ancho}";
    }
}
