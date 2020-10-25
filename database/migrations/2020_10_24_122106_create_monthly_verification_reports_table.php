<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyVerificationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_verification_reports', function (Blueprint $table) {
            $table->id();
            $table->string("month")->nullable();
            $table->string("year")->nullable();
            $table->text("verification_team");
            $table->text("recommendations");
            $table->text("performance_score_details");
            $table->text("clsg_details");
            $table->foreign('wsp_id')->references('id')->on('wsps');
            $table->unsignedInteger('wsp_id');
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
        Schema::dropIfExists('monthly_verification_reports');
    }
}
