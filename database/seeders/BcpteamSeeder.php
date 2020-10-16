<?php
namespace Database\Seeders;

use App\Models\Bcpteam;
use Illuminate\Database\Seeder;

class BcpteamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bcpteam::factory()->count(10)->create();
    }
}
