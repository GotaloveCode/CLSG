<?php
namespace Database\Seeders;

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
        Bcp::factory()->count(10)->create();
    }
}
