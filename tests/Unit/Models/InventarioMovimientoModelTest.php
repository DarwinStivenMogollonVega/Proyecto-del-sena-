<?php
namespace Tests\Unit\Models;

use Tests\TestCase;

class InventarioMovimientoModelTest extends TestCase
{
    public function test_skip_if_model_missing()
    {
        if (! class_exists(\App\Models\InventarioMovimiento::class)) {
            $this->markTestSkipped('Model App\\Models\\InventarioMovimiento no existe en esta instalación.');
            return;
        }

        $m = new \App\Models\InventarioMovimiento();
        $this->assertNotEmpty($m->getFillable());
        // Common relations: usuario and producto may exist
        if (method_exists($m, 'user')) {
            $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $m->user());
        }
        if (method_exists($m, 'producto')) {
            $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $m->producto());
        }
    }
}
