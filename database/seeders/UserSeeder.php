<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()
            ->count(2)
            ->hasPostedFoods(2)
            ->create();
        //assign role to user foreach user
        $user->each(function ($user) {
            $user->assignRole(RolesEnum::USER->value);
        });
    }
}
