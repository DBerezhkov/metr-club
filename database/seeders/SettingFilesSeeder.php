<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_files')->insert(
            [
                'name' => 'Удалять файлы заявок старше 90 дней',
                'setting' => 'delete_old_files',
                'enabled' => true,
                ],
        );

        DB::table('setting_files')->insert(
            [
                'name' => 'Резервное копирование',
                'setting' => 'backup_files',
                'path_to_backup' => 'clients/',
                'enabled' => true,
            ],
        );
    }
}
