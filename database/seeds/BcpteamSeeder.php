<?php

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
        factory(Bcpteam::class, 10)->create();
    }
}
