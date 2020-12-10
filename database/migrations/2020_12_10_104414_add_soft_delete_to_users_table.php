<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->string('id_number')->nullable();
//            $table->string('phone')->nullable();
//            $table->timestamp('phone_verified_at')->nullable();
            $table->softDeletes()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->dropColumn('id_number');
//            $table->dropColumn('phone');
//            $table->dropColumn('phone_verified_at');
            $table->dropColumn('deleted_at');
        });
    }
}
