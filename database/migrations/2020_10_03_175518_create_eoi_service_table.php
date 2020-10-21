<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEoiServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eoi_service', function (Blueprint $table) {
            $table->increments('id');
            $table->string('areas');
            $table->integer('total');
            $table->unsignedInteger('eoi_id');
            $table->foreign('eoi_id')->references('id')->on('eois');
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
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
        Schema::dropIfExists('eoi_service');
    }
}
