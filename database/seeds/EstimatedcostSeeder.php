<?php

use App\Models\Estimatedcost;
use Illuminate\Database\Seeder;

class EstimatedcostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estimatedcost::create(['name' => 'Tanker services']);
        Estimatedcost::create(['name' => 'Hand washing stations ']);
        Estimatedcost::create(['name' => 'Individual connections']);
        Estimatedcost::create(['name' => 'Free connections']);
        Estimatedcost::create(['name' => 'Public standpoints']);
    }
}
