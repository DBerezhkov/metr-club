<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EdisStringColunmsInRewardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->longText('mail_for_demands')->change();
            $table->longText('curator')->change();
            $table->longText('lk')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rewards', function (Blueprint $table) {
            //
        });
    }
}
