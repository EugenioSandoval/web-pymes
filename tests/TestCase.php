<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // En CI no se compilan los estilos (npm run build), así que las pruebas no dependen de ellos.
        $this->withoutVite();
    }
}
