<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBcpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bcps', function (Blueprint $table) {
            $table->renameColumn('planning_assumptions', 'rationale');
            $table->renameColumn('introduction', 'environment_analysis');
            $table->text('company_overview')->after('executive_summary');
            $table->text('financing')->after('company_overview');
            $table->text('strategic_direction')->after('financing');
            $table->string('status')->default('Pending')->after('planning_assumptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bcps', function (Blueprint $table) {
            $table->renameColumn('rationale','planning_assumptions');
            $table->renameColumn( 'environment_analysis','introduction');
            $table->dropColumn('company_overview');
            $table->dropColumn('financing');
            $table->dropColumn('strategic_direction');
            $table->dropColumn('status');
        });
    }
}
