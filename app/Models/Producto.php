<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'album_id',
        'precio',
        'descuento',
        'cantidad',
        'descripcion',
        'lista_canciones',
        'imagen',
        'categoria_id',
        'catalogo_id',
        'formato_id',
        'proveedor_id',
        'artista_id',
        'anio_lanzamiento',
    ];

    protected $casts = [
        'lista_canciones' => 'array',
    ];

    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con catálogo
    public function catalogo()
    {
        // If the new `formatos` table exists and `Catalogo` delegates to `Formato`,
        // the owner key is `formato_id` on the `formatos` table. Otherwise use legacy `catalogo_id`.
        if (Schema::hasTable('formatos')) {
            return $this->belongsTo(Catalogo::class, 'catalogo_id', 'formato_id');
        }

        return $this->belongsTo(Catalogo::class, 'catalogo_id', 'catalogo_id');
    }

    // Relación con formato (nueva)
    public function formato()
    {
        return $this->belongsTo(Formato::class, 'formato_id', 'formato_id');
    }

    public function artista()
    {
        return $this->belongsTo(Artista::class, 'artista_id', 'artista_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'proveedor_id');
    }

    public function resenas()
    {
        return $this->hasMany(ProductoResena::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'album_id');
    }
}
