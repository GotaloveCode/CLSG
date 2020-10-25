<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MonthlyVerification;

class MonthlyVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MonthlyVerification::create(['name'=>'Business Continuity Plan (BCP) approved by the Board','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'COVID-19 Emergency Response Plan (ERP) for vulnerable consumers approved by the Board','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'Monthly reporting on BCP and ERP activities','type'=>'']);
        MonthlyVerification::create(['name'=>'Improved financial management of the CLSG. Personnel expenditures as a percentage of O&M expenditures shall not vary by more than 5% of the amounts spent in the previous period','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'Quarterly reporting on the performance of the CLSG (pass/fail)','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'Regulatory compliance (pass/fail)','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'Maintain at least 50 percent collection efficiency','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'Maintain NRW at pre-COVID levels','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'Maintain at least 8 hours of service per day in urban areas','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'Maintain drinking water quality within acceptable range ','type'=>'Performance Score']);
        MonthlyVerification::create(['name'=>'Verified amount of revenues collected during in the month (KES) ','type'=>'Determination']);
        MonthlyVerification::create(['name'=>'Grant Multiplier for this month (as per CLSG Agreement) ','type'=>'Determination']);
        MonthlyVerification::create(['name'=>'Gross CLSG Amount (KES)','type'=>'Determination']);
        MonthlyVerification::create(['name'=>'Performance Adjusted- CLSG Amount (KES)','type'=>'Determination']);
    }
}
