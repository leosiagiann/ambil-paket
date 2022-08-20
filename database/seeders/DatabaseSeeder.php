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
        TypeBank::create(['name' => 'BRI',],);
        TypeBank::create(['name' => 'BCA',],);
        TypeBank::create(['name' => 'Mandiri',],);
        TypeBank::create(['name' => 'BNI',],);
        TypeBank::create(['name' => 'BTPN',],);
        TypeBank::create(['name' => 'Dana',],);
        TypeBank::create(['name' => 'OVO',],);
        TypeBank::create(['name' => 'LinkAja',],);
        Role::create(['name' => 'super_admin',],);
        Role::create(['name' => 'admin',]);
        Role::create(['name' => 'finance',]);
        Role::create(['name' => 'agen',]);
        Role::create(['name' => 'customer',]);
        User::factory(10)->create();
    }
}