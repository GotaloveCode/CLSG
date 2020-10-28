<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyGrantMultipliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_grant_multipliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amount');
            $table->integer('month');
            $table->year('year');
            $table->unsignedInteger('bcp_id');
            $table->foreign('bcp_id')->references('id')->on('bcps');
            $table->timestamps();
            $table->unique(['bcp_id','month','year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_grant_multipliers');
    }
}
