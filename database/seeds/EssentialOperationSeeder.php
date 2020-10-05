<?php

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
        factory(EssentialOperation::class, 10)->create();
    }
}
