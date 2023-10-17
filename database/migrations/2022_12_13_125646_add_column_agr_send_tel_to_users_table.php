<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAgrSendTelToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('agr_send_pd')->default(1)->after('agent_registration_data');
            $table->boolean('agr_send_pd_is_read')->default(0)->after('agr_send_pd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('agr_send_pd');
            $table->dropColumn('agr_send_pd_is_read');
        });
    }
}
