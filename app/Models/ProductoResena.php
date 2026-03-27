<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoResena extends Model
{
    // Usar la tabla y campos alineados con la migración
    protected $table = 'resenas_producto';

    // La migración crea la PK como `resena_producto_id`
    protected $primaryKey = 'resena_producto_id';

    protected $fillable = [
        'producto_id',
        'usuario_id',
        'puntuacion',
        'comentario',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Alias esperado por vistas/servicios: `user` (mantener compatibilidad)
    public function user()
    {
        return $this->usuario();
    }

    public function getIdAttribute()
    {
        return $this->{$this->getKeyName()};
    }
}
