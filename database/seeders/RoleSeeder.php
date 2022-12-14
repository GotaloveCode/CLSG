<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wsp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
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

        Permission::firstOrCreate(['name' => 'create_wsps']);
        Artisan::call('auth:permission users');
        $create_staff = Permission::firstOrCreate(['name' => 'create_staff']);
        $create_eoi = Permission::firstOrCreate(['name' => 'create_eoi']);
        $view_eoi = Permission::firstOrCreate(['name' => 'view_eoi']);
        $create_bcp = Permission::firstOrCreate(['name' => 'create_bcp']);
        $view_bcp = Permission::firstOrCreate(['name' => 'view_bcp']);
        $list_bcp = Permission::firstOrCreate(['name' => 'list_bcp']);
        $review_bcp = Permission::firstOrCreate(['name' => 'review_bcp']);
        $create_erp = Permission::firstOrCreate(['name' => 'create_erp']);
        $view_erp = Permission::firstOrCreate(['name' => 'view_erp']);
        $list_eoi = Permission::firstOrCreate(['name' => 'list_eoi']);
        $review_eoi = Permission::firstOrCreate(['name' => 'review_eoi']);
        $review_erp = Permission::firstOrCreate(['name' => 'review_erp']);
        $list_erp = Permission::firstOrCreate(['name' => 'list_erp']);
        Artisan::call('auth:permission roles');

        $wsp->syncPermissions([$create_eoi, $create_bcp, $create_erp, $create_staff, $view_eoi, $view_bcp, $view_erp]);
        $wasreb->syncPermissions([$list_eoi, $review_eoi, $list_bcp, $review_bcp, $list_erp, $review_erp, $view_eoi, $view_bcp, $view_erp]);
        $wstf->syncPermissions([$list_eoi, $review_eoi, $list_bcp, $review_bcp, $list_erp, $review_erp, $view_eoi, $view_bcp, $view_erp]);
        $admin->syncPermissions([
            $create_staff, $view_eoi, $view_bcp, $view_erp,
            $list_eoi, $review_eoi, $list_bcp, $review_bcp, $list_erp, $review_erp,
            'create_roles', 'view_roles', 'delete_roles', 'edit_roles',
            'create_users', 'view_users', 'delete_users', 'edit_users'
        ]);

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
                'managing_director' => 'Moses Nzioki'
            ]);

        $user_exists = $water_company->users->contains($user->id);

        if (!$user_exists) {
            $water_company->users()->attach($user->id);
        }

        $user = User::firstOrNew([
            'email' => 'info@bungomawater.test'],
            ['name' => 'Bungoma Water & Sewerage Company',
                'password' => bcrypt('password')
            ]);

        $user->assignRole($wsp);

        $water_company = Wsp::firstOrCreate([
            'name' => 'Bungoma Water & Sewerage Company'],
            [
                'email' => 'info@bungomawater.test',
                'acronym' => 'BWS',
                'postal_address' => '494',
                'physical_address' => 'Bungoma',
                'postal_code_id' => 12,
                'managing_director' => 'Vincent Kituyi'
            ]);

        $user_exists = $water_company->users->contains($user->id);

        if (!$user_exists) {
            $water_company->users()->attach($user->id);
        }

        $user = User::firstOrCreate([
            'email' => 'info@nyeriwater.test'],
            ['name' => 'Nyeri Water & Sewerage Company',
                'password' => bcrypt('password')
            ]);

        $user->assignRole($wsp);

        $water_company = Wsp::firstOrCreate([
            'name' => 'Nyeri Water & Sewerage Company'],
            [
                'email' => 'info@nyeriwater.test',
                'acronym' => 'NYEWASCO',
                'postal_address' => '22',
                'physical_address' => 'Nyeri',
                'postal_code_id' => 4,
                'managing_director' => 'Martin Iriga'
            ]);

        $user_exists = $water_company->users->contains($user->id);

        if (!$user_exists) {
            $water_company->users()->attach($user->id);
        }


    }
}
