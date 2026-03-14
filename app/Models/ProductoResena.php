<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoResena extends Model
{
    protected $table = 'producto_resenas';

    protected $fillable = [
        'producto_id',
        'user_id',
        'puntuacion',
        'comentario',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
