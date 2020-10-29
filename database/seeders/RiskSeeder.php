<?php

namespace Database\Seeders;

use App\Models\Risk;
use Illuminate\Database\Seeder;

class RiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Risk::firstOrCreate(['name' => 'Failure to reach intended beneficiaries']);
        Risk::firstOrCreate(['name' => 'Vandalism by beneficiaries']);
        Risk::firstOrCreate(['name' => 'Failure to reach intended beneficiaries']);
        Risk::firstOrCreate(['name' => 'Gender Based Violence (GBV)']);
        Risk::firstOrCreate(['name' => 'Declare existing connections as new connections']);
        Risk::firstOrCreate(['name' => 'Compensation for easements']);
        Risk::firstOrCreate(['name' => 'Poor maintenance of free connections']);
        Risk::firstOrCreate(['name' => 'Other']);
    }
}
