<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Album;

class AlbumsSeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            'Colombia Tierra Querida',
            'The Hits Live',
            'Conexión',
            'My Latin Soul',
            'El Dorado',
            'La Tierra del Olvido',
            'Secos & Molhados',
            'La cultura de la basura',
            '¿Dónde están los ladrones?',
            'Un Día Normal',
            'Amor Prohibido',
            'Barrio Fino',
            'Para Siempre',
            'Mi Biografía',
            'La Vida... Es Un Ratico',
            'Grandes Éxitos',
            'Latin Oldies Vol.1',
            'Sueño Stereo',
            'Thriller',
            'Nevermind',
        ];

        foreach ($albums as $name) {
            Album::firstOrCreate(['nombre' => $name], ['activo' => true]);
        }
    }
}
