<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('credit_data');
            $table->text('period')->after('insurance_data');
            $table->float('summ', 16,2)->after('insurance_data')->default(0);
            $table->float('amount',16,2)->after('insurance_data')->default(0);
            $table->tinyInteger('status')->after('insurance_data')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('period');
            $table->dropColumn('summ');
            $table->dropColumn('amount');
            $table->dropColumn('status');
        });
    }
}
