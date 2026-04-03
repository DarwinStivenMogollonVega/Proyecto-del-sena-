<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Categoria;
use App\Models\Catalogo;
use App\Models\Formato;
use App\Models\Proveedor;
use App\Models\Artista;
use App\Models\Producto;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        // Crear/asegurar categorías de género según catálogo proporcionado
        $categoriaNames = [
            'Música colombiana / Folclor', 'Salsa', 'Vallenato', 'Jazz latino', 'Rock latino', 'Vallenato / Pop', 'Rock / MPB',
            'Pop latino', 'Pop rock', 'Tex-Mex', 'Reggaetón', 'Ranchera', 'Balada', 'Clásicos latinos', 'Rock en español', 'Pop', 'Rock / Grunge'
        ];

        $categorias = collect();
        foreach ($categoriaNames as $name) {
            $categorias->put($name, Categoria::firstOrCreate(
                ['nombre' => $name],
                ['descripcion' => $name . ' - Categoría musical', 'activo' => true]
            ));
        }

        // Crear/asegurar formatos (reemplaza catálogos conceptualmente)
        $formatos = collect();
        foreach (['Vinilo', 'Casete', 'CD'] as $name) {
            $f = Formato::firstOrCreate(
                ['nombre' => $name],
                ['descripcion' => 'Formato: ' . $name, 'activo' => true]
            );
            $formatos->put($name, $f);
        }

        $proveedor = Proveedor::firstOrCreate(
            ['email' => 'ventas@discosdisc music.test'],
            [
                'nombre' => 'Proveedor DiscMusic',
                'contacto' => 'ventas',
                'telefono' => '6010000000',
                'direccion' => 'Dirección genérica',
                'descripcion' => 'Proveedor por defecto para seeders',
                'activo' => true,
            ]
        );

        // Definir los 20 productos proporcionados por el usuario
        $productsData = [
            ['nombre' => 'Vinilo LP Colombia Tierra Querida', 'artista' => 'Varios artistas', 'categoria' => 'Música colombiana / Folclor', 'formato' => 'Vinilo', 'descripcion' => 'Recopilación de clásicos colombianos tradicionales, ideal para colección cultural.', 'precio' => 120000, 'anio_lanzamiento' => 1980],
            ['nombre' => 'Richie Ray & Bobby Cruz – The Hits Live', 'artista' => 'Richie Ray & Bobby Cruz', 'categoria' => 'Salsa', 'formato' => 'Vinilo', 'descripcion' => 'Grabación en vivo con los mayores éxitos de salsa clásica.', 'precio' => 185000, 'anio_lanzamiento' => 1975],
            ['nombre' => 'Daniel Calderón – Conexión', 'artista' => 'Daniel Calderón', 'categoria' => 'Vallenato', 'formato' => 'Vinilo', 'descripcion' => 'Álbum moderno de vallenato romántico colombiano.', 'precio' => 120000, 'anio_lanzamiento' => 2011],
            ['nombre' => 'Bobby Matos – My Latin Soul', 'artista' => 'Bobby Matos', 'categoria' => 'Jazz latino', 'formato' => 'Vinilo', 'descripcion' => 'Mezcla de jazz y ritmos latinos con percusión intensa.', 'precio' => 114000, 'anio_lanzamiento' => 2001],
            ['nombre' => 'Aterciopelados – El Dorado', 'artista' => 'Aterciopelados', 'categoria' => 'Rock latino', 'formato' => 'Vinilo', 'descripcion' => 'Disco icónico del rock colombiano con mezcla de punk, reggae y folclor.', 'precio' => 140000, 'anio_lanzamiento' => 1995],
            ['nombre' => 'Carlos Vives – La Tierra del Olvido', 'artista' => 'Carlos Vives', 'categoria' => 'Vallenato / Pop', 'formato' => 'Vinilo', 'descripcion' => 'Álbum que revolucionó el vallenato mezclándolo con rock y pop.', 'precio' => 130000, 'anio_lanzamiento' => 1995],
            ['nombre' => 'Secos & Molhados – Secos & Molhados', 'artista' => 'Secos & Molhados', 'categoria' => 'Rock / MPB', 'formato' => 'Vinilo', 'descripcion' => 'Álbum clásico brasileño con fuerte contenido cultural y político.', 'precio' => 150000, 'anio_lanzamiento' => 1973],
            ['nombre' => 'Los Prisioneros – La cultura de la basura', 'artista' => 'Los Prisioneros', 'categoria' => 'Rock latino', 'formato' => 'Vinilo', 'descripcion' => 'Disco crítico del contexto social chileno en los 80.', 'precio' => 140000, 'anio_lanzamiento' => 1987],
            ['nombre' => 'Shakira – ¿Dónde están los ladrones?', 'artista' => 'Shakira', 'categoria' => 'Pop latino', 'formato' => 'Casete', 'descripcion' => 'Álbum icónico que lanzó a Shakira a nivel internacional.', 'precio' => 50000, 'anio_lanzamiento' => 1998],
            ['nombre' => 'Juanes – Un Día Normal', 'artista' => 'Juanes', 'categoria' => 'Pop rock', 'formato' => 'Casete', 'descripcion' => 'Incluye éxitos como “A Dios le pido”.', 'precio' => 45000, 'anio_lanzamiento' => 2002],
            ['nombre' => 'Selena – Amor Prohibido', 'artista' => 'Selena', 'categoria' => 'Tex-Mex', 'formato' => 'Casete', 'descripcion' => 'Álbum legendario de música latina en EE.UU.', 'precio' => 60000, 'anio_lanzamiento' => 1994],
            ['nombre' => 'Daddy Yankee – Barrio Fino', 'artista' => 'Daddy Yankee', 'categoria' => 'Reggaetón', 'formato' => 'Casete', 'descripcion' => 'Disco clave en la historia del reggaetón.', 'precio' => 55000, 'anio_lanzamiento' => 2004],
            ['nombre' => 'Vicente Fernández – Para Siempre', 'artista' => 'Vicente Fernández', 'categoria' => 'Ranchera', 'formato' => 'Casete', 'descripcion' => 'Música tradicional mexicana con gran éxito comercial.', 'precio' => 50000, 'anio_lanzamiento' => 2007],
            ['nombre' => 'Diomedes Díaz – Mi Biografía', 'artista' => 'Diomedes Díaz', 'categoria' => 'Vallenato', 'formato' => 'Casete', 'descripcion' => 'Clásico del vallenato colombiano.', 'precio' => 45000, 'anio_lanzamiento' => 1995],
            ['nombre' => 'Juanes – La Vida... Es Un Ratico', 'artista' => 'Juanes', 'categoria' => 'Pop latino', 'formato' => 'CD', 'descripcion' => 'Álbum ganador de premios Grammy Latino.', 'precio' => 40000, 'anio_lanzamiento' => 2007],
            ['nombre' => 'Ana Gabriel – Grandes Éxitos', 'artista' => 'Ana Gabriel', 'categoria' => 'Balada', 'formato' => 'CD', 'descripcion' => 'Recopilación de éxitos románticos.', 'precio' => 50000, 'anio_lanzamiento' => 1996],
            ['nombre' => 'Latin Oldies Vol.1', 'artista' => 'Varios artistas', 'categoria' => 'Clásicos latinos', 'formato' => 'CD', 'descripcion' => 'Compilación de éxitos clásicos latinos.', 'precio' => 60000, 'anio_lanzamiento' => 1985],
            ['nombre' => 'Soda Stereo – Sueño Stereo', 'artista' => 'Soda Stereo', 'categoria' => 'Rock en español', 'formato' => 'CD', 'descripcion' => 'Uno de los discos más importantes del rock latino.', 'precio' => 55000, 'anio_lanzamiento' => 1995],
            ['nombre' => 'Michael Jackson – Thriller', 'artista' => 'Michael Jackson', 'categoria' => 'Pop', 'formato' => 'CD', 'descripcion' => 'Álbum más vendido de la historia.', 'precio' => 45000, 'anio_lanzamiento' => 1982],
            ['nombre' => 'Nirvana – Nevermind', 'artista' => 'Nirvana', 'categoria' => 'Rock / Grunge', 'formato' => 'CD', 'descripcion' => 'Álbum clave del grunge en los 90.', 'precio' => 50000, 'anio_lanzamiento' => 1991],
        ];

        // Crear artistas necesarios
        $artistas = collect();
        foreach ($productsData as $p) {
            $name = $p['artista'];
            $ident = Str::slug(substr($name, 0, 40));
            $artistas->put($name, Artista::firstOrCreate(
                ['identificador_unico' => $ident],
                ['nombre' => $name, 'slug' => Str::slug($name), 'foto' => null, 'biografia' => 'Artista importado desde catálogo', 'activo' => true]
            ));
        }

        // Crear albums basados en 'nombre de producto' o en título extraído
        $albumsMap = collect();
        foreach ($productsData as $p) {
            // intentar extraer título después del '–' si existe
            $title = $p['nombre'];
            if (strpos($title, '–') !== false) {
                $parts = explode('–', $title, 2);
                $albumName = trim($parts[1]);
            } else {
                // si no hay guion, usar el nombre entero como álbum
                $albumName = trim($title);
            }
            $album = \App\Models\Album::firstOrCreate(['nombre' => $albumName], ['activo' => true]);
            $albumsMap->put($p['nombre'], $album);
        }

        // Insertar o actualizar productos y vincular
        foreach ($productsData as $p) {
            $categoria = $categorias->firstWhere('nombre', $p['categoria']);
            $artista = $artistas->get($p['artista']);

            Producto::updateOrCreate([
                'nombre' => $p['nombre']
            ], [
                'codigo' => strtoupper(Str::random(8)),
                'nombre' => $p['nombre'],
                'precio' => $p['precio'],
                'descuento' => 0,
                'cantidad' => 10,
                'descripcion' => $p['descripcion'],
                'lista_canciones' => [],
                'imagen' => 'default-product.jpg',
                'categoria_id' => $categoria ? $categoria->getKey() : null,
                'catalogo_id' => null,
                'formato_id' => ($formatos->has($p['formato']) ? $formatos->get($p['formato'])->getKey() : null),
                'proveedor_id' => $proveedor->getKey(),
                'artista_id' => $artista ? $artista->getKey() : null,
                'album_id' => $albumsMap->get($p['nombre'])->getKey(),
                'anio_lanzamiento' => $p['anio_lanzamiento'] ?? null,
                'activo' => true,
            ]);
        }
    }
}
