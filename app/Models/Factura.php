<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'factura_id';
    protected $fillable = [
        'pedido_id',
        'usuario_id',
        'numero_factura',
        'fecha_emision',
        'estado_pedido',
        'subtotal',
        'impuestos',
        'total',
        // Columnas usadas por la migración
        'nombre_cliente',
        'correo_cliente',
        'direccion_cliente',
        'identificacion_cliente',
        // Compatibilidad con nombres antiguos en código
        'cliente_nombre',
        'cliente_email',
        'cliente_direccion',
        'cliente_identificacion',
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
        'subtotal' => 'float',
        'impuestos' => 'float',
        'total' => 'float',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function getIdAttribute()
    {
        return $this->{$this->getKeyName()};
    }
}
