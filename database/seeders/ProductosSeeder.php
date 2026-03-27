<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Producto;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 sample productos ensuring unique `codigo` and valid fields
        for ($i = 1; $i <= 10; $i++) {
            $codigo = strtoupper('P' . str_pad((string) $i, 5, '0', STR_PAD_LEFT));
            Producto::create([
                'codigo' => $codigo,
                'nombre' => "Producto de prueba #{$i}",
                'precio' => (float) number_format(rand(500, 5000) / 100, 2),
                'descuento' => 0,
                'cantidad' => rand(1, 100),
                'descripcion' => "Descripción de prueba para el producto {$i}.",
                'lista_canciones' => null,
                'imagen' => null,
                'categoria_id' => null,
                'catalogo_id' => null,
                'proveedor_id' => null,
                'artista_id' => null,
                'anio_lanzamiento' => null,
            ]);
        }
    }
}
