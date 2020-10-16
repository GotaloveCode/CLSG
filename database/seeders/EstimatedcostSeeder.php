<?php
namespace Database\Seeders;

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
        Estimatedcost::firstOrCreate(['name' => 'Tanker services']);
        Estimatedcost::firstOrCreate(['name' => 'Hand washing stations ']);
        Estimatedcost::firstOrCreate(['name' => 'Individual connections']);
        Estimatedcost::firstOrCreate(['name' => 'Free connections']);
        Estimatedcost::firstOrCreate(['name' => 'Public standpoints']);
    }
}
