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
            $table->increments('id');
            $table->string('areas');
            $table->integer('total');
            $table->unsignedInteger('connection_id');
            $table->foreign('connection_id')->references('id')->on('connections');
            $table->unsignedInteger('eoi_id');
            $table->foreign('eoi_id')->references('id')->on('eois');
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
        Schema::dropIfExists('connection_eoi');
    }
}
