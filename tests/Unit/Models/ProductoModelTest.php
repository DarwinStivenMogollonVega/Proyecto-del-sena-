<?php
namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Producto;

class ProductoModelTest extends TestCase
{
    public function test_fillable_and_casts()
    {
        $prod = new Producto();
        $this->assertContains('nombre', $prod->getFillable());
        $this->assertArrayHasKey('lista_canciones', $prod->getCasts());
    }

    public function test_relations_return_relations()
    {
        $prod = new Producto();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $prod->categoria());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $prod->artista());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $prod->resenas());
    }
}
