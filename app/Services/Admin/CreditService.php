<?php

namespace App\Services\Admin;

use App\Models\Credit;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;

class CreditService
{
    public static function deleteFileFromCredit(Credit $credit) {
        $fileSystem = new Filesystem();
        $names = json_decode($credit->files);
        foreach ($names as $name) {
            try {
                $file = new File(public_path('/clients/credits' . $credit->uid . '/' . $name));
                $fileSystem->delete($file);
            } catch (FileNotFoundException $e) {
            }
        }
        return response()->json(['message' => 'Файлы удалены']);
    }
}
