<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditSettingsColumnsToBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->boolean('enabled_credit')->nullable();
            $table->string('email_credit')->nullable();
            $table->string('email_copy_credit')->nullable();
            $table->string('alt_contact_credit')->nullable();
            $table->foreignId('demand_template_credit_id')->nullable()->index()->constrained('demand_templates');
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
            $table->dropColumn('enabled_credit');
            $table->dropColumn('email_credit');
            $table->dropColumn('email_copy_credit');
            $table->dropColumn('alt_contact_credit');
            $table->dropConstrainedForeignId('demand_template_credit_id');
        });
    }
}
