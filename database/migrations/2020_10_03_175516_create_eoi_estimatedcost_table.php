<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEoiEstimatedcostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eoi_estimatedcost', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit');
            $table->string('total');
            $table->unsignedInteger('eoi_id');
            $table->foreign('eoi_id')->references('id')->on('eois');
            $table->unsignedInteger('estimatedcost_id');
            $table->foreign('estimatedcost_id')->references('id')->on('estimatedcosts');
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
        Schema::dropIfExists('eoi_estimatedcost');
    }
}
