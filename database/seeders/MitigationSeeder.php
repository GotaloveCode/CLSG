<?php

namespace Database\Seeders;

use App\Models\Mitigation;
use Illuminate\Database\Seeder;

class MitigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mitigation::firstOrCreate(['name' => 'Acknowledgement of receipt by beneficiaries (signed delivery note)']);
        Mitigation::firstOrCreate(['name' => 'Follow the project COVID 19 SOP']);
        Mitigation::firstOrCreate(['name' => 'Provide security by the WSP']);
        Mitigation::firstOrCreate(['name' => 'Management by beneficiaries committee']);
        Mitigation::firstOrCreate(['name' => 'WSP to assign officers to manage or keep the connections functional.']);
        Mitigation::firstOrCreate(['name' => 'GBV Action Plan']);
        Mitigation::firstOrCreate(['name' => 'WSP to assign officers to manage or keep the connections functional.']);
        Mitigation::firstOrCreate(['name' => 'Follow the project COVID 19 SOP']);
        Mitigation::firstOrCreate(['name' => 'Prepare designs/routes that avoids encroachment into private property']);
        Mitigation::firstOrCreate(['name' => 'Undertake a baseline of targeted connections by WSP']);
        Mitigation::firstOrCreate(['name' => 'Follow the project COVID 19 SOP']);
        Mitigation::firstOrCreate(['name' => 'Other']);
    }
}
