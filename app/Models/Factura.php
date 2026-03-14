<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = [
        'pedido_id',
        'user_id',
        'numero_factura',
        'fecha_emision',
        'estado_pedido',
        'subtotal',
        'impuestos',
        'total',
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
        return $this->belongsTo(User::class);
    }
}
