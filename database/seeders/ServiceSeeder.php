<?php
namespace Database\Seeders;

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
        Service::firstOrCreate(['name' => 'Hand washing stations ']);
        Service::firstOrCreate(['name' => 'Individual connections']);
        Service::firstOrCreate(['name' => 'Free connections']);
        Service::firstOrCreate(['name' => 'Public standpoints']);
    }
}
