<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('advanced_description');
            $table->string('mail_for_demands')->nullable();
            $table->string('curator')->nullable();
            $table->string('lk')->nullable();
            $table->string('bank_contacts')->nullable();
            $table->boolean('only_text')->default(0);
            $table->string('text')->nullable();
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
        Schema::dropIfExists('rewards');
    }
}
