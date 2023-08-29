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
            }
        });

    }

    private function assignAdminPermissions(Role $role): void
    {
        $role->syncPermissions([
            'create food',
            'view food',
            'update food',
            'delete food',
            'view foods',
            'view any food',
        ]);
    }
}
