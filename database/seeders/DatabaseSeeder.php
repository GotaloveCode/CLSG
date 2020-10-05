<?php

namespace Database\Seeders;

use BcpSeeder;
use BcpteamSeeder;
use ConnectionSeeder;
use ContractorSeeder;
use EoiSeeder;
use EssentialfunctionSeeder;
use EssentialOperationSeeder;
use EssentialsupplySeeder;
use EstimatedcostSeeder;
use Illuminate\Database\Seeder;
use OperationcostSeeder;
use PostalCodeSeeder;
use RevenueSeeder;
use ServiceSeeder;
use StaffSeeder;
use WspSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PostalCodeSeeder::class);
        $this->call(WspSeeder::class);
        $this->call(EssentialfunctionSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(BcpSeeder::class);
        $this->call(OperationcostSeeder::class);
        $this->call(EoiSeeder::class);
        $this->call(EstimatedcostSeeder::class);
        $this->call(ConnectionSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(EssentialsupplySeeder::class);
        $this->call(ContractorSeeder::class);
        $this->call(RevenueSeeder::class);
        $this->call(EssentialOperationSeeder::class);
        $this->call(BcpteamSeeder::class);
    }
}
