<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->getPermission()->each(function ($permission) {
            Permission::create(['name' => $permission]);
        });
    }

    private function getPermission(): Collection
    {
        return collect(config('foody_permission'))->flatten();
    }
}
