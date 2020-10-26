<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportingFormart;

class ReportingFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportingFormart::create(["name"=>"Business Continuity Plan (BCP) approved by the Board","type"=>"Performance Scorecard"]);
        ReportingFormart::create(["name"=>"COVID-19 Emergency Response Plan (ERP) for vulnerable consumers approved by the Board","type"=>"Performance Scorecard"]);
        ReportingFormart::create(["name"=>"Monthly reporting on BCP and ERP activities","type"=>"General"]);
        ReportingFormart::create(["name"=>"Improved financial management of the CLSG. Personnel expenditures as a percentage of O&M expenditures shall not vary by more than 5% of the amounts spent in the previous period","type"=>"Performance Scorecard"]);
        ReportingFormart::create(["name"=>"Quarterly reporting on the performance of the CLSG (pass/fail)","type"=>"Performance Scorecard"]);
        ReportingFormart::create(["name"=>"Regulatory compliance (pass/fail)","type"=>"Performance Scorecard"]);
        ReportingFormart::create(["name"=>"Maintain at least 50 percent collection efficiency","type"=>"Performance Scorecard"]);
        ReportingFormart::create(["name"=>"Maintain NRW at pre-COVID levels","type"=>"Performance Scorecard"]);
        ReportingFormart::create(["name"=>"Maintain at least 8 hours of service per day in urban areas","type"=>"Performance Scorecard"]);
        ReportingFormart::create(["name"=>"Maintain drinking water quality within acceptable range","type"=>"Performance Scorecard"]);
    }
}
