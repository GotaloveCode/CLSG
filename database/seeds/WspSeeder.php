<?php

use App\Models\Wsp;
use Illuminate\Database\Seeder;

class WspSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Wsp::class, 10)->create();
    }
}
