<?php

namespace App\Domains\Shared\Services\LaravelPermissions;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $guarded = [];
}
