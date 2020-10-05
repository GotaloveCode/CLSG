<?php

use App\Models\Eoi;
use Illuminate\Database\Seeder;

class EoiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Eoi::class, 10)->create();
    }
}
