<?php

namespace App\Helpers;

use File;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Symfony\Component\HttpFoundation\Response;
use ZipArchive;

class FolderHelper
{
    public static function getFile($fileName)
    {
        $path = session('student')->folderPath() . $fileName;

        $type = explode('.', $fileName)[1] == 'pdf' ? 'application/pdf' : 'image/jpg';
        $headers = [
            'Content-Type'        =>  $type,
            'Content-Disposition' => 'filename="' . $fileName . '"',
        ];

        return response(Storage::disk('s3')->get($path))->withHeaders($headers);
    }

    public static function storeFile($file, $fileName)
    {
        $path = session('student')->folderPath();
        $file->storeAs($path,  $fileName, 's3');
    }

    public static function deleteFile($fileName)
    {
        Storage::disk('s3')->delete($fileName);
        @unlink(storage_path('app/registrations/' .$fileName));
    }

    public static function cleanDirectory($path)
    {
        $files = File::files($path);

        foreach ($files as $key => $value) {
            File::delete($value);
        }
    }

    public static function downloadZip($fileName, $student = null)
    {
        $basePath = storage_path('app/registrations/');

        Storage::makeDirectory('registrations');

        $filePath = $basePath . $fileName;

        if ($student != null) {
            $zip = new Filesystem(new ZipArchiveAdapter($filePath));
            $source_disk = 's3';
            $files = Storage::disk($source_disk)->files($student->folderPath());

            foreach ($files as $file) {
                $currentFileName = FileHelper::getFileName($file,  $student->fullName());
                $fileContent = Storage::disk($source_disk)->get($file);
                $zip->put($currentFileName, $fileContent);
            }
            $zip->getAdapter()->getArchive()->close();
        } else {

            $zip = new ZipArchive;
            if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {

                $files = File::files($basePath);

                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }

                $zip->close();
            } else {
            }
        }

        $headers = array(
            'Content-Type: application/zip',
            'Content-disposition: attachment; filename:`' . $fileName . '`'
        );
        return response()->download($filePath, $fileName, $headers);
    }
}
