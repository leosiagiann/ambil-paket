<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'super_admin',
        ]);
        Role::create([
            'name' => 'admin',
        ]);
        Role::create([
            'name' => 'finance',
        ]);
        Role::create([
            'name' => 'agen',
        ]);
        Role::create([
            'name' => 'customer',
        ]);
        User::factory(10)->create();
    }
}