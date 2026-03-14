<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'method',
        'route_name',
        'url',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
