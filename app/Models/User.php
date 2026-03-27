<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /**
     * Usar la tabla 'usuarios' en vez de 'users'.
     */
    protected $table = 'usuarios';
    /**
     * Nombre de la clave primaria en la tabla 'usuarios'.
     */
    protected $primaryKey = 'usuario_id';
    /**
     * Incrementing primary key (entero).
     */
    public $incrementing = true;
    /**
     * Tipo de la clave primaria.
     */
    protected $keyType = 'int';
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
        'avatar',
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

    /**
     * Compatibilidad: devolver `id` usando la columna real de la llave primaria.
     */
    public function getIdAttribute()
    {
        return $this->{$this->primaryKey} ?? null;
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'usuario_id');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'usuario_id');
    }

    public function inventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimiento::class, 'usuario_id');
    }

    public function adminActivityLogs()
    {
        return $this->hasMany(AdminActivityLog::class, 'usuario_id');
    }
}
