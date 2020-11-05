<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_scores', function (Blueprint $table) {
            $table->id();
            $table->integer("month");
            $table->year("year");
            $table->tinyInteger("drinking_water");
            $table->text("drinking_water_comment")->nullable();
            $table->string("drinking_water_score");
            $table->string("compliance_score");
            $table->tinyInteger("collection_efficiency");
            $table->text("collection_efficiency_comment")->nullable();
            $table->string("collection_efficiency_score");
            $table->tinyInteger("nrw");
            $table->text("nrw_comment")->nullable();
            $table->string("nrw_score");
            $table->string("financial_score");
            $table->string("erp_score");
            $table->string("performance_score");
            $table->string("bcp_score");
            $table->string("bcp_erp_score");
            $table->tinyInteger("service_per_day");
            $table->text("service_per_day_comment")->nullable();
            $table->string("service_per_day_score");
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
        Schema::dropIfExists('performance_scores');
    }
}
