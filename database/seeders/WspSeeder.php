<?php
namespace Database\Seeders;

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
        Wsp::factory()->count(10)->create();
    }
}
