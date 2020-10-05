<?php

use App\Models\Bcp;
use Illuminate\Database\Seeder;

class BcpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Bcp::class, 10)->create();
    }
}
