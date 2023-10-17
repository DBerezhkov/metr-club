<?php

namespace App\Services\Admin;


use App\Models\Demand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;

class DemandService
{
    public static function deleteFileFromDemand(Demand $demand): \Illuminate\Http\JsonResponse
    {
        $fileSystem = new Filesystem();
        $names = json_decode($demand->files);
        foreach ($names as $name) {
            try {
                $file = new File(public_path('/clients/' . $demand->uid . '/' . $name));
                $fileSystem->delete($file);
            } catch (FileNotFoundException $e) {
            }
        }
        return response()->json(['message' => 'Файлы удалены']);
    }

}
