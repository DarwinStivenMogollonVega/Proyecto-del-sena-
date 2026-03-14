<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    protected $fillable = [
        'nombre',
        'slug',
        'foto',
        'biografia',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
