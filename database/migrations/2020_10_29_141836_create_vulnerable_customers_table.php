<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVulnerableCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vulnerable_customers', function (Blueprint $table) {
            $table->id();
            $table->string("month");
            $table->string("year");
            $table->text("customer_details");
            $table->foreign('bcp_id')->references('id')->on('bcps');
            $table->unsignedInteger('bcp_id');
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('vulnerable_customers');
    }
}
