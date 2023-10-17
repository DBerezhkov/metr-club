<?php

namespace App\Console;
use App\Models\Demand;
use App\Models\SettingFile;
use App\Models\Settings;
use Arhitector\Yandex\Disk;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use ITPolice\YandexDisk\YandexDiskAdapter;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;

class DeleteOldFilesFromDemands
{
    public function __invoke()
    {
        $demandsOlderNinetyDays = Demand::where('created_at', '<', (Carbon::now()->subDays(90)))->get();
        if(SettingFile::where('setting', 'backup_files')->value('enabled') == 1){
            Storage::extend('yandex-disk', function ($app, $config) {
                $client = new Disk(Settings::where('setting', 'yandex_disk_token')->value('param'));
                return new \League\Flysystem\Filesystem(new YandexDiskAdapter($client, $config['prefix']));
            });
            $path_to_backup = SettingFile::where('setting', 'backup_files')->value('path_to_backup');
            foreach ($demandsOlderNinetyDays as $demand) {
                $names = json_decode($demand->files);
                foreach ($names as $name) {
                    try {
                        $file = new File(public_path('/clients/' . $demand -> uid . '/' . $name));
                        if(isset($file) && !Storage::disk('yandex-disk')->exists($path_to_backup . $demand -> uid . '/' . $name)){
                            Storage::disk('yandex-disk')->put($path_to_backup . $demand -> uid . '/' . $name, $file->getContent());
                            logger('By demand with uid ' . $demand -> uid . ', the files were transferred to yandex-disk');
                        }
                    } catch (FileNotFoundException $e){
                    }
                }
            }

        }
        if(SettingFile::where('setting', 'delete_old_files')->value('enabled') == 1){
            $fileSystem = new Filesystem();
            $counter = 0;
            $totalSize = 0;
            foreach ($demandsOlderNinetyDays as $demand) {
                $names = json_decode($demand->files);
                foreach ($names as $name) {
                    try {
                        $file = new File(public_path('/clients/' . $demand -> uid . '/' . $name));
                        $size = $file->getSize();
                        logger('deleted file from the demand size: ' . $size . ' file path: ' . $file->getRealPath());
                        $fileSystem->delete($file);
                        $counter++;
                        $totalSize += $size;
                    } catch (FileNotFoundException $e){
                    }
                }
            }
            logger('Total deleted ' . $counter . ' files with a total size of ' .  number_format($totalSize / 1048576, 2) . ' megabytes');
        }
        }
}




