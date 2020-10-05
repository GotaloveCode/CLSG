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
            $table->bigIncrements('id');
            $table->timestamp('date')->nullable();
            $table->string('program_manager');
            $table->string('fixed_grant');
            $table->string('variable_grant');
            $table->string('emergency_intervention');
            $table->string('operation_costs');
            $table->integer('months');
            $table->text('water_service_areas');
            $table->integer('total_people_water_served');
            $table->string('proportion_served');
            $table->unsignedBigInteger('wsp_id')->nullable();
            $table->foreign('wsp_id')->references('id')->on('wsps');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
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
