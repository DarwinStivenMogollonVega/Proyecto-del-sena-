<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class PermissionCustom extends SpatiePermission
{
    protected $primaryKey = 'permission_id';
}
