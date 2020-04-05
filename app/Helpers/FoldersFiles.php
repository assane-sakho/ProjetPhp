<?php

namespace App\Helpers;

use Response;
use File;
use ZipArchive;

class FoldersFiles
{

    public static function getFile($fileName)
    {
        $path = FoldersFiles::getPath() . $fileName;

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }

    public static function saveFile($file, $fileName)
    {
        $image['filePath'] = $file->getClientOriginalName();
        $path = FoldersFiles::getPath();
        $file->move($path, $fileName);
    }

    public static function deleteFile($fileName)
    {
        $pathToFile = FoldersFiles::getPath() . $fileName;
        File::delete($pathToFile);
    }

    public static function getPath($studentId = null)
    {
        $_studentId = session()->has('student') ? session('student')->id : $studentId;
        return storage_path() . '/uploads/' . $_studentId . '/';
    }

    public static function downloadZip($studentId, $fileName)
    {
        $zip = new ZipArchive;

        $path = storage_path() . '/registrations/' . $fileName;
        $pathFiles = FoldersFiles::getPath($studentId);
        if ($zip->open($path, ZipArchive::CREATE) === TRUE) {
            $files = File::files($pathFiles);

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }
        $headers = array(
            'Content-Type: application/zip',
            'Content-disposition: attachment; filename:"' . $fileName . '"'
        );

        return response()->download($path, $fileName, $headers);
    }
}
