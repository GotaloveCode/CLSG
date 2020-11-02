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
            $table->tinyInteger("challenges");
            $table->text("challenges_cooment")->nullable();
            $table->double("clsg_total");
            $table->text("expected_activities");
            $table->double("operations_costs");
            $table->double("revenue");
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
