<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpOperationcostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_operationcost', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cost');
            $table->unsignedInteger('erp_id');
            $table->foreign('erp_id')->references('id')->on('erps');
            $table->unsignedInteger('operationcost_id');
            $table->foreign('operationcost_id')->references('id')->on('operationcosts');
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
        Schema::dropIfExists('erp_operationcost');
    }
}
