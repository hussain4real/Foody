<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminUser = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'mobile_number' => '1234566789',
            'building_number' => '123',
            'street' => 'street',
            'zone' => 'zone',
            'city' => 'city',
            'email' => 'super@foody.com',
            'password' => bcrypt('super123'),
            'email_verified_at' => now(),

        ]);
        User::find($superAdminUser->id)->assignRole(RolesEnum::SUPER_ADMIN->value);
    }
}
