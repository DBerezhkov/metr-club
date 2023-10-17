<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use File;

class ZipController extends Controller
{
    public function zipFile(Request $request){
        $zip = new ZipArchive();
        $filename = $request->clientname . '.zip';
        if(strripos(url()->previous(), 'credits')){
            $file_path = public_path('/clients/credits/'.$request->uid) . '/' . $filename;
        } else {
            $file_path = public_path('/clients/'.$request->uid) . '/' . $filename;
        }

        if(File::exists($file_path)) File::delete($file_path);
        if($zip->open($file_path, ZipArchive::CREATE) === TRUE) {
            if(strripos(url()->previous(), 'credits')){
                $files = File::files(public_path('/clients/credits/'.$request->uid));
            }
            else {
                $files = File::files(public_path('/clients/'.$request->uid));
            }
            foreach($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                //logger($value);
                //logger($key);
                //logger(basename($value));
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }
        //return response()->download(public_path($filename));
        if(strripos(url()->previous(), 'credits')){
            return '/clients/credits/'.$request->uid . '/' . $filename;
        } else {
            return '/clients/'.$request->uid . '/' . $filename;
        }
    }
}
