<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcpMonthlyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bcp_monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->string("month")->nullable();
            $table->year("year")->nullable();
            $table->text("essential");
            $table->text("customer");
            $table->text("staff");
            $table->text("communication");
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
        Schema::dropIfExists('bcp_monthly_reports');
    }
}
