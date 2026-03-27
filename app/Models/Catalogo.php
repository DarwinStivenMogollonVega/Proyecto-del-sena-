<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    protected $table = 'catalogos';
    protected $primaryKey = 'catalogo_id';
    protected $fillable = ['nombre', 'descripcion'];
    public function productos()
{
    return $this->hasMany(Producto::class, 'catalogo_id', 'catalogo_id');
}

    public function getIdAttribute()
    {
        return $this->{$this->getKeyName()};
    }
}
