<?php

use App\Models\Essentialfunction;
use Illuminate\Database\Seeder;

class EssentialfunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Essentialfunction::create(['name' => 'Water Treatment']);
        Essentialfunction::create(['name' => 'Pumping']);
        Essentialfunction::create(['name' => 'Water Treatment and Pumping Equipment Repair']);
        Essentialfunction::create(['name' => 'Distribution System Water Testing']);
        Essentialfunction::create(['name' => 'Equipment Maintenance']);
        Essentialfunction::create(['name' => 'Leak detection and Repair']);
        Essentialfunction::create(['name' => 'Billing and Revenue collection']);
    }
}
