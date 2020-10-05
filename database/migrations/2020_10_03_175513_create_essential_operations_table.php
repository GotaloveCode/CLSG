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
            $table->bigIncrements('id');
            $table->string('priority_level');
            $table->unsignedBigInteger('essentialfunction_id')->nullable();
            $table->foreign('essentialfunction_id')->references('id')->on('essentialfunctions');
            $table->integer('primary_staff');
            $table->integer('backup_staff');
            $table->unsignedBigInteger('bcp_id')->nullable();
            $table->foreign('bcp_id')->references('id')->on('bcps');
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
        Schema::dropIfExists('essential_operations');
    }
}
