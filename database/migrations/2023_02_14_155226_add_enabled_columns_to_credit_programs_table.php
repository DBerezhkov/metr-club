<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnabledColumnsToCreditProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credit_programs', function (Blueprint $table) {
            $table->boolean('enabled_demands')->default(1)->after('title');
            $table->boolean('enabled_credits')->default(1)->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_programs', function (Blueprint $table) {
            $table->dropColumn('enabled_demands');
            $table->dropColumn('enabled_credits');
        });
    }
}
