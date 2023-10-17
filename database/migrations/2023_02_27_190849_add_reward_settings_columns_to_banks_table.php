<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRewardSettingsColumnsToBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->string('banks_logo')->nullable()->after('programs_credit');
            $table->boolean('is_has_reward')->nullable()->after('banks_logo');
            $table->string('type_percent')->nullable()->after('is_has_reward');
            $table->float('max_size_reward')->nullable()->after('type_percent');
            $table->text('short_list_programs')->nullable()->after('max_size_reward');
            $table->text('full_list_programs')->nullable()->after('short_list_programs');
            $table->text('extra_conditions')->nullable()->after('full_list_programs');
            $table->json('files')->nullable()->after('extra_conditions');
            $table->json('contacts')->nullable()->after('files');
            $table->boolean('enabled_reward')->nullable()->after('contacts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('banks_logo');
            $table->dropColumn('is_has_reward');
            $table->dropColumn('type_percent');
            $table->dropColumn('max_size_reward');
            $table->dropColumn('short_list_programs');
            $table->dropColumn('full_list_programs');
            $table->dropColumn('extra_conditions');
            $table->dropColumn('files');
            $table->dropColumn('contacts');
            $table->dropColumn('enabled_reward');
        });
    }
}
