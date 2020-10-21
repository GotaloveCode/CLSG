<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcpteamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bcpteams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('unit');
            $table->string('role');
            $table->unsignedInteger('bcp_id');
            $table->foreign('bcp_id')->references('id')->on('bcps');
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
        Schema::dropIfExists('bcpteams');
    }
}
