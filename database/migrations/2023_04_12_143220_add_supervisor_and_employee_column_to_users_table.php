<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupervisorAndEmployeeColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_supervisor')->default(false)->after('rating');
            $table->boolean('is_employee')->default(false)->after('is_supervisor');
            $table->foreignId('supervisor_id')->nullable()->after('is_employee')->index()->constrained('users');

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
            $table->dropColumn('is_supervisor');
            $table->dropColumn('is_employee');
            $table->dropForeign('users_supervisor_id_foreign');
            $table->dropColumn('supervisor_id');
        });
    }
}
