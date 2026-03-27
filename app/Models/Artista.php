<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    protected $primaryKey = 'artista_id';
    protected $fillable = [
        'nombre',
        'slug',
        'foto',
        'biografia',
        'identificador_unico',
    ];
    

    public function productos()
    {
    return $this->hasMany(Producto::class, 'artista_id', 'artista_id');
    }

    // Backwards compatible `id` attribute for code that expects `id`
    public function getIdAttribute()
    {
        return $this->{$this->getKeyName()};
    }
}
