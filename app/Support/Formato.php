<?php

namespace App\Support;

class Formato
{
    /** 15000 -> "$15.000" */
    public static function clp(int|float|null $monto): string
    {
        return '$'.number_format((float) $monto, 0, ',', '.');
    }
}
