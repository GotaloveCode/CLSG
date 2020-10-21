<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eois', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date')->nullable();
            $table->string('program_manager');
            $table->string('fixed_grant');
            $table->string('variable_grant');
            $table->string('emergency_intervention_total');
            $table->string('operation_costs_total');
            $table->integer('months');
            $table->text('water_service_areas');
            $table->integer('total_people_water_served');
            $table->string('proportion_served');
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
        Schema::dropIfExists('eois');
    }
}
