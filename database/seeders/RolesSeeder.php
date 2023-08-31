<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(RolesEnum::getConstants())->map(function ($role) {
            $userRole = Role::firstOrCreate(['name' => $role]);

            if ($role === RolesEnum::ADMIN) {
                $this->assignAdminPermissions(role: $userRole);
            } elseif ($role === RolesEnum::SUPER_ADMIN) {
                $userRole->syncPermissions(Permission::all());
            } else {
                $this->assignUserPermissions(role: $userRole);
            }
        });

    }

    private function assignAdminPermissions(Role $role): void
    {
        $role->syncPermissions([
            'create Food',
            'view Food',
            'update Food',
            'delete Food',
            'view Foods',
            'view any Food',
        ]);
    }

    private function assignUserPermissions(Role $role): void
    {
        $role->syncPermissions([
            'create Food',
            'view Food',
            'update Food',
            'delete Food',
            'view Foods',
            'view any Food',
        ]);
    }
}
