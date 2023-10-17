<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_credits', function (Blueprint $table) {
            $table->id();
            $table->longText('advanced_description');
            $table->longText('description');
            $table->longText('mail_for_demands');
            $table->longText('curator');
            $table->longText('lk');
            $table->longText('bank_contacts')->nullable();
            $table->boolean('only_text')->default(0);
            $table->longText('text')->nullable();
            $table->longText('img');
            $table->boolean('enabled')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reward_credits');
    }
}
