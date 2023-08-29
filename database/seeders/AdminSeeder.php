<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'mobile_number' => '1234567890',
            'building_number' => '123',
            'street' => 'street',
            'zone' => 'zone',
            'city' => 'city',
            'email' => 'admin@foody.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
        ]);
        User::find($adminUser->id)->assignRole(RolesEnum::ADMIN->value);
    }
}
