<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    protected $table = 'formatos';
    protected $primaryKey = 'formato_id';
    protected $fillable = ['nombre', 'descripcion', 'activo'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'formato_id', 'formato_id');
    }

    public function getIdAttribute()
    {
        return $this->{$this->getKeyName()};
    }
}
