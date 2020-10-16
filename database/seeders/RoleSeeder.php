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
        $wasreb = Role::firstOrCreate(['name' => 'wasreb']);
        $wstf = Role::firstOrCreate(['name' => 'wstf']);
        $admin = Role::firstOrCreate(['name' => 'Super Admin']);

        Permission::firstOrCreate(['name' => 'create-wsps']);
        $create_users = Permission::firstOrCreate(['name' => 'create-users']);
        $create_eoi = Permission::firstOrCreate(['name' => 'create-eoi']);
        $list_eoi = Permission::firstOrCreate(['name' => 'list-eoi']);
        $review_eoi = Permission::firstOrCreate(['name' => 'review-eoi']);
        $comment_eoi = Permission::firstOrCreate(['name' => 'comment-eoi']);

        $wsp->syncPermissions([$create_eoi, $comment_eoi]);
        $wasreb->syncPermissions([$list_eoi, $review_eoi, $comment_eoi]);
        $wstf->syncPermissions([$list_eoi, $review_eoi, $comment_eoi,]);

        $user = User::firstOrCreate([
            'name' => 'Super Admin'],
            ['email' => 'superadmin@credible.com',
                'password' => bcrypt('password')
            ]);

        $user->assignRole($admin);

        $user = User::firstOrCreate([
            'name' => 'Wasreb Admin'],
            ['email' => 'admin@wareb.com',
                'password' => bcrypt('password')
            ]);

        $user->assignRole($wasreb);

    }
}
