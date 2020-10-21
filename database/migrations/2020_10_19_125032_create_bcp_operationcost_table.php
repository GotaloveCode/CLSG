<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcpOperationcostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bcp_operationcost', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quantity')->nullable();
            $table->string('unit_rate');
            $table->string('total');
            $table->unsignedInteger('operationcost_id');
            $table->foreign('operationcost_id')->references('id')->on('operationcosts');
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
        Schema::dropIfExists('bcp_operationcost');
    }
}
