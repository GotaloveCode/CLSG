<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCslgCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cslg_calculations', function (Blueprint $table) {
            $table->id();
            $table->integer("month");
            $table->year("year");
            $table->string('revenue');
            $table->string('monthly_grant_multiplier');
            $table->string('actual_performance_score');
            $table->integer('adjusted_performance_score');
            $table->string('fixed_grant');
            $table->string('gross_clsg');
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('cslg_calculations');
    }
}
