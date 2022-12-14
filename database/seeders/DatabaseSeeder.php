<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostalCodeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EssentialfunctionSeeder::class);
        $this->call(OperationcostSeeder::class);
        $this->call(EstimatedcostSeeder::class);
        $this->call(ConnectionSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ChecklistSeeder::class);
        $this->call(MonthlyVerificationSeeder::class);
        $this->call(MitigationSeeder::class);
        $this->call(RiskSeeder::class);

//        $this->call(WspSeeder::class);
//        $this->call(StaffSeeder::class);
//        $this->call(BcpSeeder::class);
//        $this->call(EoiSeeder::class);
//        $this->call(RevenueSeeder::class);
//        $this->call(EssentialOperationSeeder::class);
//        $this->call(BcpteamSeeder::class);

    }
}
