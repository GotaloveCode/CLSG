<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWspTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wsp', function (Blueprint $table) {
            $table->id();
            $table->foreign('wsp_id')->references('id')->on('wsps');
            $table->unsignedInteger('wsp_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->unique(['wsp_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wsp');
    }
}
