<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EditRefinPercentColumnToDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demands', function (Blueprint $table) {

            $demands = DB::table('demands')->whereNotNull('refin_percent')->pluck( "refin_percent", "id")->toArray();
            foreach ($demands as $id => $refin_percent) {
                $refin_percent = str_ireplace([',', '%', ' '], ['.', '', ''], $refin_percent);
                \App\Models\Demand::find($id)->update([
                    'refin_percent' => $refin_percent
                ]);
            }
            $table->float('refin_percent')->nullable()->change();
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
            $table->string('refin_percent')->nullable()->change();
        });
    }
}
