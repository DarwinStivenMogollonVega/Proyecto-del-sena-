<?php
namespace Tests\Unit\Models;

use Tests\TestCase;

class EntradaModelTest extends TestCase
{
    public function test_skip_if_model_missing()
    {
        if (! class_exists(\App\Models\Entrada::class)) {
            $this->markTestSkipped('Model App\\Models\\Entrada no existe en esta instalación.');
            return;
        }

        $entrada = new \App\Models\Entrada();
        $this->assertNotEmpty($entrada->getFillable());
    }
}
