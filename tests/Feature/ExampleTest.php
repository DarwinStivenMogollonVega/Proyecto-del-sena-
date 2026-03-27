<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Producto;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Crear un producto mínimo para evitar consultas que fallen en index
        Producto::create([
            'codigo' => 'TEST-001',
            'nombre' => 'Producto de prueba',
            'precio' => 100.00,
            'cantidad' => 5,
            'descripcion' => 'Producto creado por test',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
