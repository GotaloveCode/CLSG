<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionEoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection_eoi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('areas');
            $table->integer('total');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('connection_id')->nullable();
            $table->foreign('connection_id')->references('id')->on('connections');
            $table->unsignedBigInteger('eoi_id')->nullable();
            $table->foreign('eoi_id')->references('id')->on('eois');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection_eoi');
    }
}
