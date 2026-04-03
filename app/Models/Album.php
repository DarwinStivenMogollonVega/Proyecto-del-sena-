<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';
    protected $primaryKey = 'album_id';
    protected $fillable = ['nombre', 'descripcion'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'album_id', 'album_id');
    }
}
