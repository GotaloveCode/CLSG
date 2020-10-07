<?php

namespace Database\Seeders;

use App\Models\User;
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
        $admin = Role::firstOrCreate(['name' => 'Super Admin']);

        Permission::firstOrCreate(['name' => 'create-wsps']);
        $create_users = Permission::firstOrCreate(['name' => 'create-users']);
        $create_eoi = Permission::firstOrCreate(['name' => 'create-eoi']);

        $wsp->syncPermissions([$create_eoi]);

        $user = User::firstOrCreate([
            'name' => 'Super Admin',
            'email' => 'superadmin@credible.com',
            'password' => bcrypt('password')
        ]);

        $user->assignRole($admin);

    }
}
