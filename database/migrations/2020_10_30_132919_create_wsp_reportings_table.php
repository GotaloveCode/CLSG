<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWspReportingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsp_reportings', function (Blueprint $table) {
            $table->id();
            $table->string("month");
            $table->string("year");
            $table->text("bcp_erp_evidence")->nullable();
            $table->string("bcp_erp_score");
            $table->text("bcp_evidence")->nullable();
            $table->string("bcp_score");
            $table->tinyInteger("challenges");
            $table->text("challenges_cooment")->nullable();
            $table->double("clsg_total");
            $table->tinyInteger("collection_efficiency");
            $table->text("collection_efficiency_comment")->nullable();
            $table->string("collection_efficiency_score");
            $table->text("compliance_evidence")->nullable();
            $table->string("compliance_score");
            $table->tinyInteger("drinking_water");
            $table->text("drinking_water_comment")->nullable();
            $table->string("drinking_water_score");
            $table->text("erp_evidence")->nullable();
            $table->string("erp_score");
            $table->text("expected_activities");
            $table->text("financial_evidence")->nullable();
            $table->string("financial_score");
            $table->tinyInteger("nrw");
            $table->text("nrw_comment")->nullable();
            $table->string("nrw_score");
            $table->double("operations_costs");
            $table->text("performance_evidence")->nullable();
            $table->string("performance_score");
            $table->double("revenue");
            $table->tinyInteger("service_per_day");
            $table->text("service_per_day_comment")->nullable();
            $table->text("status_of_covid_implementation");
            $table->tinyInteger("status_of_resolution");
            $table->text("status_of_resolution_comment")->nullable();
            $table->foreign('bcp_id')->references('id')->on('bcps');
            $table->unsignedInteger('bcp_id');
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
        Schema::dropIfExists('wsp_reportings');
    }
}
