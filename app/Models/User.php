<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activo',
        'telefono',
        'documento_identidad',
        'fecha_nacimiento',
        'direccion',
        'ciudad',
        'pais',
        'codigo_postal',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
        ];
    }

    public function entradas(){
        return $this->hasMany(Entrada::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }

    public function inventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimiento::class);
    }

    public function adminActivityLogs()
    {
        return $this->hasMany(AdminActivityLog::class);
    }
}
