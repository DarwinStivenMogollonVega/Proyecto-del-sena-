<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'usuario_id',
        'total',
        'estado',
        'nombre',
        'email',
        'telefono',
        'direccion',
        'metodo_pago',
        'comprobante_pago',
        'requiere_factura_electronica',
        'tipo_documento',
        'numero_documento',
        'razon_social',
        'correo_factura',
    ];

    protected $casts = [
        'requiere_factura_electronica' => 'boolean',
    ];
    
    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}
