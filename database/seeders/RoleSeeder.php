<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wsp = Role::firstOrCreate(['name' => 'wsp']);
        Role::create(['name' => 'wasreb']);
        Role::create(['name' => 'wstf']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        Permission::firstOrCreate(['name' => 'create-wsps']);

    }
}
