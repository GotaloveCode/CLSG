<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWspsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('acronym');
            $table->string('email')->unique();
            $table->string('postal_address');
            $table->string('physical_address');
            $table->foreign('postal_code_id')->references('id')->on('postal_codes');
            $table->string('managing_director')->nullable();
            $table->unsignedInteger('postal_code_id');
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
        Schema::dropIfExists('wsps');
    }
}
