<?php

use App\Models\Essentialsupply;
use Illuminate\Database\Seeder;

class EssentialsupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Essentialsupply::create(['name' => 'Chlorine']);
        Essentialsupply::create(['name' => 'Other essential chemicals']);
        Essentialsupply::create(['name' => 'Water Main Repair']);
    }
}
