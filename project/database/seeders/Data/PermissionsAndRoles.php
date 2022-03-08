<?php

namespace Database\Seeders\Data;

use Illuminate\Support\Collection;

class PermissionsAndRoles
{
    public static function getRoles(): array
    {
        $allPermissions = static::getPermissions();
        return [
            'admin' => [
                'users' => $allPermissions['users'],
            ],
        ];
    }

    public static function getPermissions(): array
    {
        return [
            'users' => static::crud(),
        ];
    }

    private static function crud(array $except = []): Collection
    {
        return collect(['view', 'view any', 'create', 'update', 'delete', 'force delete', 'restore'])
            ->except($except);
    }
}
