<?php
namespace Database\Seeders;

use App\Models\Operationcost;
use Illuminate\Database\Seeder;

class OperationcostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operationcost::create(['name' => 'Chemicals']);
        Operationcost::create(['name' => 'Electricity ']);
        Operationcost::create(['name' => 'Spare parts for essential maintenance']);
        Operationcost::create(['name' => 'Administration costs']);
        Operationcost::create(['name' => 'Regulatory levies and fees']);
        Operationcost::create(['name' => 'Salaries for WSP staff ']);
    }
}
