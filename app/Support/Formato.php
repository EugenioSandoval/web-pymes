<?php

namespace App\Support;

class Formato
{
    /** 15000 -> "$15.000" */
    public static function clp(int|float|null $monto): string
    {
        return '$'.number_format((float) $monto, 0, ',', '.');
    }

    /**
     * URL de una foto: si es un número, es el ID de una foto de Pexels;
     * si es texto, es una ruta dentro de public/ (por ejemplo 'img/rubros/panaderia.jpg').
     */
    public static function foto(int|string $foto, int $ancho = 800): string
    {
        if (is_string($foto) && ! ctype_digit($foto)) {
            return asset($foto);
        }

        return "https://images.pexels.com/photos/{$foto}/pexels-photo-{$foto}.jpeg?auto=compress&cs=tinysrgb&w={$ancho}";
    }
}
