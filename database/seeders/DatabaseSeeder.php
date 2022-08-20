<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;
use App\Models\TypeBank;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        TypeBank::create(
            ['name' => 'BRI',],
            ['name' => 'BNI',],
            ['name' => 'BCA',],
            ['name' => 'Mandiri',],
            ['name' => 'Dana',],
            ['name' => 'Ovo',],
            ['name' => 'LinkAja',],
        );
        Role::create(
            ['name' => 'super_admin',],
            ['name' => 'admin',],
            ['name' => 'finance',],
            ['name' => 'agen',],
            ['name' => 'customer',],
        );
        User::factory(10)->create();
    }
}