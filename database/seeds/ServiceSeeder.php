<?php

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create(['name' => 'Hand washing stations ']);
        Service::create(['name' => 'Individual connections']);
        Service::create(['name' => 'Free connections']);
        Service::create(['name' => 'Public standpoints']);
    }
}
