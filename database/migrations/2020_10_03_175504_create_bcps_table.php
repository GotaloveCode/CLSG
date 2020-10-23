<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBcpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bcps', function (Blueprint $table) {
            $table->increments('id');
            $table->text('executive_summary');
            $table->text('introduction');
            $table->text('planning_assumptions');
            $table->text('training');
            $table->text('emergency_response_plan');
            $table->text('staff_health_protection');
            $table->text('emergency_response_plan');
            $table->text('supply_chain');
            $table->text('communication_plan');
            $table->string('government_subsidy')->nullable();
            $table->unsignedInteger('wsp_id');
            $table->foreign('wsp_id')->references('id')->on('wsps');
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
        Schema::dropIfExists('bcps');
    }
}
