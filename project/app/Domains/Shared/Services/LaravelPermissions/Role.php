<?php

namespace App\Domains\Shared\Services\LaravelPermissions;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $guarded = [];
}
