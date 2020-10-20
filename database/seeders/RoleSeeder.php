<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wsp;
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
        $create_bcp = Permission::firstOrCreate(['name' => 'create-bcp']);
        $create_erp = Permission::firstOrCreate(['name' => 'create-erp']);
        $list_eoi = Permission::firstOrCreate(['name' => 'list-eoi']);
        $review_eoi = Permission::firstOrCreate(['name' => 'review-eoi']);
        $comment_eoi = Permission::firstOrCreate(['name' => 'comment-eoi']);

        $wsp->syncPermissions([$create_eoi, $comment_eoi, $create_bcp, $create_erp]);
        $wasreb->syncPermissions([$list_eoi, $review_eoi, $comment_eoi]);
        $wstf->syncPermissions([$list_eoi, $review_eoi, $comment_eoi,]);

        $user = User::firstOrCreate([
            'name' => 'Super Admin'],
            ['email' => 'superadmin@credible.com',
                'password' => bcrypt('password')
            ]);

        $user->assignRole($admin);

        $user = User::firstOrCreate([
            'name' => 'WSTF Admin'],
            ['email' => 'admin@wstf.test',
                'password' => bcrypt('password')
            ]);

        $user->assignRole($wstf);

        $user = User::firstOrCreate([
            'name' => 'Wasreb Admin'],
            ['email' => 'admin@wasreb.test',
                'password' => bcrypt('password')
            ]);

        $user->assignRole($wasreb);

        $user = User::firstOrCreate([
            'email' => 'info@nairobiwater.test'],
            ['name' => 'Nairobi Water & Sewerage Company',
                'password' => bcrypt('password')
            ]);

        $user->assignRole($wsp);

        $water_company = Wsp::firstOrCreate([
            'name' => 'Nairobi Water & Sewerage Company'],
            [
                'email' => 'info@nairobiwater.test',
                'acronym' => 'NWS',
                'postal_address' => '494',
                'physical_address' => 'Westlands',
                'postal_code_id' => 12,
                'managing_director' => 'Alehandro DMore'
            ]);

        $user_exists = $water_company->users->contains($user->id);

        if (!$user_exists) {
            $water_company->users()->attach($user->id);
        }

    }
}
