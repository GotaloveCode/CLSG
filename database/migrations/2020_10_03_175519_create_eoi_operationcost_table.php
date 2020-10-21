<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEoiOperationcostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eoi_operationcost', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quantity')->nullable();
            $table->string('unit_rate');
            $table->string('total');
            $table->unsignedInteger('eoi_id');
            $table->foreign('eoi_id')->references('id')->on('eois');
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
        Schema::dropIfExists('eoi_operationcost');
    }
}
