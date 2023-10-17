<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert(
            [
                'title' => 'Москва и МО',
            ],
        );

        DB::table('regions')->insert(
            [
                'title' => 'Краснодар и Краснодарский край',
            ],
        );
    }
}
