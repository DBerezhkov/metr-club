<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRefinBodyToDemandTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demand_templates', function (Blueprint $table) {
            $table->longText('refin_body')->nullable()->after('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demand_templates', function (Blueprint $table) {
            $table->dropColumn('refin_body');
        });
    }
}
