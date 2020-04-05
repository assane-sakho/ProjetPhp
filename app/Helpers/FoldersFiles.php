<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Registration;
use App\ReportCard;
use Response;
use File;

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
        File::delete(FoldersFiles::getPath() . $fileName);
    }

    public static function getPath()
    {
        $studentId = session('student')->id;
        return storage_path() . '/uploads/' . $studentId . '/';
    }
}
