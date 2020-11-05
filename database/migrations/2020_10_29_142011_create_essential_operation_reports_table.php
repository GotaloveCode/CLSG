<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEssentialOperationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('essential_operation_reports', function (Blueprint $table) {
            $table->id();
            $table->text("details");
            $table->integer("month");
            $table->year("year");
            $table->foreign('bcp_id')->references('id')->on('bcps');
            $table->unsignedInteger('bcp_id');
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
        Schema::dropIfExists('essential_operation_reports');
    }
}
