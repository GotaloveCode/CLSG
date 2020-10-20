<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coordinator');
            $table->string('period')->default('MAY 2020 - DECEMBER 2020');
            $table->foreign('wsp_id')->references('id')->on('wsps');
            $table->unsignedInteger('wsp_id');
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
        Schema::dropIfExists('erps');
    }
}
