<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emergency_intervention');
            $table->text('risks');
            $table->text('mitigation');
            $table->string('cost');
            $table->text('other');
            $table->foreign('erp_id')->references('id')->on('erps');
            $table->unsignedInteger('erp_id');
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
        Schema::dropIfExists('erp_items');
    }
}
