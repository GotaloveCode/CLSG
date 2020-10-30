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
            $table->string("month");
            $table->string("year");
            $table->double('revenues');
            $table->text('revenues_comment');
            $table->double('grant_multiplier_amount');
            $table->text('grant_multiplier_comment');
            $table->double('cslg_gross_amount');
            $table->text('cslg_gross_comment');
            $table->double('cslg_adjusted_amount');
            $table->text('cslg_adjusted_comment');
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
