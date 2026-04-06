<?php
namespace Tests\Unit\Models;

use Tests\TestCase;

class ProductoImagenModelTest extends TestCase
{
    public function test_skip_if_model_missing()
    {
        if (! class_exists(\App\Models\ProductoImagen::class)) {
            $this->markTestSkipped('Model App\\Models\\ProductoImagen no existe en esta instalación.');
            return;
        }

        $img = new \App\Models\ProductoImagen();
        $this->assertNotEmpty($img->getFillable());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $img->producto());
    }
}
