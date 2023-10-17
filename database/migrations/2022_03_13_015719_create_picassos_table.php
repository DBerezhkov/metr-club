<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePicassosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picassos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->integer('agent_id');
            $table->string('clientname');
            $table->string('date_of_birth');
            $table->string('passport_sn');
            $table->string('passport_who', 500);
            $table->string('passport_when');
            $table->string('passport_code');
            $table->string('inn');
            $table->string('banks');
            $table->string('salary');
            $table->string('position');
            $table->json('files');
            $table->string('record_of_service_date');
            $table->string('employment_date');
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
        Schema::dropIfExists('picassos');
    }
}
