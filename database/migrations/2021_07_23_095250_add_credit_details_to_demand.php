<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditDetailsToDemand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->integer('estate_summ');
            $table->integer('credit_summ');
            $table->integer('first_pay_summ');
            $table->tinyInteger('first_pay_percents');
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
            //
        });
    }
}
