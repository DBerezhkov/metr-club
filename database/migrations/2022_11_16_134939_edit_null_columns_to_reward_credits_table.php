<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditNullColumnsToRewardCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reward_credits', function (Blueprint $table) {
            $table->longText('curator')->nullable()->change();
            $table->longText('lk')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reward_credits', function (Blueprint $table) {
            $table->longText('curator')->change();
            $table->longText('lk')->change();
        });
    }
}
