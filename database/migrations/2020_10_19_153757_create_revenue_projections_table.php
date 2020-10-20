<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenueProjectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenue_projections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amount');
            $table->string('month');
            $table->string('year')->default('2020');
            $table->unsignedInteger('bcp_id')->nullable();
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
        Schema::dropIfExists('revenue_projections');
    }
}
