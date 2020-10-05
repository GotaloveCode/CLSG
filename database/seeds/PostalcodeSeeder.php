<?php

use App\Models\Postalcode;
use Illuminate\Database\Seeder;

class PostalcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Postalcode::class, 10)->create();
    }
}
