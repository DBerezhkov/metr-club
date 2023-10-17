<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnsTypeToDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->float('estate_summ')->change();
            $table->float('credit_summ')->change();
            $table->float('first_pay_summ')->change();
            $table->float('refin_balance')->nullable()->change();
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
            $table->integer('estate_summ')->change();
            $table->integer('credit_summ')->change();
            $table->integer('first_pay_summ')->change();
            $table->integer('refin_balance')->nullable()->change();
        });
    }
}
