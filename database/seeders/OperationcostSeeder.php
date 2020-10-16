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
        Operationcost::firstOrCreate(['name' => 'Chemicals']);
        Operationcost::firstOrCreate(['name' => 'Electricity ']);
        Operationcost::firstOrCreate(['name' => 'Spare parts for essential maintenance']);
        Operationcost::firstOrCreate(['name' => 'Administration costs']);
        Operationcost::firstOrCreate(['name' => 'Regulatory levies and fees']);
        Operationcost::firstOrCreate(['name' => 'Salaries for WSP staff ']);
    }
}
