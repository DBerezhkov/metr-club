<?php

use App\Models\CreditProgram;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddProgramsDemandColumnToBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->json('programs_demand')->after('updated_at')->nullable();
        });
        DB::table('banks')->update(['programs_demand' => CreditProgram::query()->where('enabled_demands', true)->pluck('id')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('programs_demand');
        });
    }
}
