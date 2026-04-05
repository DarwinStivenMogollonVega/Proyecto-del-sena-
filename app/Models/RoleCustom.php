<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class RoleCustom extends SpatieRole
{
    protected $primaryKey = 'role_id';
}
