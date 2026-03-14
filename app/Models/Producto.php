<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'precio',
        'cantidad',
        'descripcion',
        'lista_canciones',
        'imagen',
        'categoria_id',
        'catalogo_id', // <- agregado
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
        return $this->belongsTo(Catalogo::class);
    }

    public function artista()
    {
        return $this->belongsTo(Artista::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function resenas()
    {
        return $this->hasMany(ProductoResena::class);
    }
}
