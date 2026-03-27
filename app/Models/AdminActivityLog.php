<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    // Table uses Spanish naming conventions
    protected $table = 'registros_actividad_admin';
    protected $primaryKey = 'registro_actividad_admin_id';

    protected $fillable = [
        'usuario_id',
        'metodo',
        'nombre_ruta',
        'url',
        'direccion_ip',
        'agente_usuario',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'usuario_id');
    }

    public function getIdAttribute()
    {
        return $this->{$this->getKeyName()};
    }
}
