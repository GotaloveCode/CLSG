<?php
namespace Database\Seeders;


use App\Models\EssentialOperation;
use Illuminate\Database\Seeder;

class EssentialOperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EssentialOperation::factory()->count(10)->make();
    }
}
