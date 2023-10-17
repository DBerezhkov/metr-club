<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariantsRateColumnToDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->json('rate_list')->nullable()->after('offices_list');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->dropColumn('rate_list');
        });
    }
}
