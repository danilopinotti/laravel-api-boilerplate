<?php

namespace Database\Seeders;

use App\Support\PermissionsHelper;
use Database\Seeders\Data\PermissionsAndRoles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $profiles = PermissionsAndRoles::getRoles();

        foreach ($profiles as $profile => $permissions) {
            $role = Role::firstOrCreate([
                'name' => $profile,
                'guard_name' => 'web',
            ]);

            $rolePermissions = PermissionsHelper::getFlattenPermissions($permissions);
            $role->syncPermissions($rolePermissions);
        }
    }
}
