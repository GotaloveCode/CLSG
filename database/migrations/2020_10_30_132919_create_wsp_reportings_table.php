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
            $table->integer("month");
            $table->year("year");
            $table->tinyInteger("challenges");
            $table->text("challenges_comment")->nullable();
            $table->string("clsg_total");
            $table->text("expected_activities");
            $table->text("operations_costs");
            $table->string("revenue");
            $table->text("status_of_covid_implementation");
            $table->tinyInteger("status_of_resolution");
            $table->text("status_of_resolution_comment")->nullable();
            $table->foreign('bcp_id')->references('id')->on('bcps');
            $table->unsignedInteger('bcp_id');
            $table->string('status')->default('Pending');
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
