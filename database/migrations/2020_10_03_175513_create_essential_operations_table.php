<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEssentialOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('essential_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('priority_level');
            $table->unsignedInteger('essentialfunction_id');
            $table->foreign('essentialfunction_id')->references('id')->on('essentialfunctions');
            $table->unsignedInteger('primary_staff');
            $table->foreign('primary_staff')->references('id')->on('staff');
            $table->unsignedInteger('backup_staff');
            $table->foreign('backup_staff')->references('id')->on('staff');
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
        Schema::dropIfExists('essential_operations');
    }
}
