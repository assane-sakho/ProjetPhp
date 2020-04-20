<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function storeFile($file, $fileName)
    {
        $student  = session('student');
        $studentFolderPath = $student->folderPath();

        $file->storeAs($studentFolderPath, $fileName, config('const.source_disk'));
    }

    public static function getFile($fileWanted, $index = null)
    {
        $student  = session('student');
        $studentFolder = $student->registration->folder;
        $studentFolderPath = $student->folderPath();

        if ($fileWanted != "report_card") {
            $fileName = $studentFolder[$fileWanted];
        } else {
            $fileName = $studentFolder->report_cards[$index]->name;
        }

        $path = $studentFolderPath . $fileName;

        $type = explode('.', $fileName)[1] == 'pdf' ? 'application/pdf' : 'image/jpg';
        $headers = [
            'Content-Type'        =>  $type,
            'Content-Disposition' => 'filename="' . $fileName . '"',
        ];

        return response(Storage::disk(config('const.source_disk'))->get($path))->withHeaders($headers);
    }

    public static function deleteFile($fileToDelete, $index = null)
    {
        $student  = session('student');
        $studentFolder = $student->registration->folder;

        if ($fileToDelete != "report_card") {
            $fileName = $studentFolder[$fileToDelete];
        } else {
            $fileName = $studentFolder->report_cards[$index]->name;
            RegistrationHelper::deleteReportCard($fileName);
        }

        $filePath = $student->folderPath() . $fileName;

        Storage::disk(config('const.source_disk'))->delete($filePath);
        @unlink(storage_path('app/registrations/' . $fileName));

        if ($fileToDelete == "report_card") {
            RegistrationHelper::updateRegistrationName($fileName);
        }
    }

    public static function getFileName($file_name,  $studentFullName)
    {
        $realName = [
            "cv" => "CV",
            "cover_letter" => "Lettre de motivation",
            "report_card_0" => "Relevé de notes n°1",
            "report_card_1" => "Relevé de notes n°2",
            "report_card_2" => "Relevé de notes n°3",
            "vle_screenshot" => "Imprime écran ENT"
        ];

        $tmpList = explode('/', $file_name);

        $file = explode('.', $tmpList[count($tmpList) - 1]);

        $fileName =  $studentFullName .  ' - ' . $realName[$file[0]];
        $ext = '.' . $file[1];

        $currentFileName =  $fileName . $ext;
        return $currentFileName;
    }

    public static function getFileArray()
    {
        $files = array(
            "cv",
            "cover_letter",
            "vle_screenshot"
        );

        for ($i = 0; $i < 3; $i++) {
            array_push($files, "report_card_" . $i);
        }
        return $files;
    }

    public static function moveFile($currentPath, $newPath)
    {
        Storage::disk(config('const.source_disk'))->move($currentPath, $newPath);
    }

    public static function getStudentFile($student)
    {
        return Storage::disk(config('const.source_disk'))->files($student->folderPath());
    }

    public static function getFileContent($file)
    {
        return Storage::disk(config('const.source_disk'))->get($file);
    }
}
