<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBcpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bcps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->('excecutive_summary');
            $table->text('introduction');
            $table->text('planning_assumptions');
            $table->unsignedBigInteger('wsp_id')->nullable();
            $table->foreign('wsp_id')->references('id')->on('wsps');
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
        Schema::dropIfExists('bcps');
    }
}
