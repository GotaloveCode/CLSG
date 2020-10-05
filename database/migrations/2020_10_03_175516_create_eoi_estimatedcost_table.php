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
            $table->bigIncrements('id');
            $table->string('unit');
            $table->string('total');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('eoi_id')->nullable();
            $table->foreign('eoi_id')->references('id')->on('eois');
            $table->unsignedBigInteger('estimatedcost_id')->nullable();
            $table->foreign('estimatedcost_id')->references('id')->on('estimatedcosts');
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
