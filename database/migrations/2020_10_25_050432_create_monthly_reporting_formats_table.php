<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyReportingFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_reporting_formats', function (Blueprint $table) {
            $table->id();
            $table->string("month");
            $table->string("year");
            $table->string("bcp_status_implementation");
            $table->string("covid_status_implementation");
            $table->double("revenues_collected");
            $table->double("o_m_costs");
            $table->double("amount_disbursed");
            $table->string("resolution_status");
            $table->text("challenges");
            $table->text("expected_activities_next_month");
            $table->text("scores_details");
            $table->foreign('wsp_id')->references('id')->on('wsps');
            $table->unsignedInteger('wsp_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_reporting_formats');
    }
}
