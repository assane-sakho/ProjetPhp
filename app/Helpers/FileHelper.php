<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Store a file in the path of the connected student 
     *
     * @var file
     * @var fileName
     */
    public static function storeFile($file, $fileName)
    {
        $student  = session('student');
        $studentFolderPath = $student->folderPath();

        $file->storeAs($studentFolderPath, $fileName, config('const.source_disk'));
    }

    /**
     * Retrieve a file
     *
     * @var fileWanted
     * @var index
     * @var studentId
     */
    public static function getFile($fileWanted, $index = null, $studentId = null)
    {
        if ($studentId != null) {
            $student = StudentHelper::getStudent($studentId);
        } else {
            $student  = session('student');
        }
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

    /**
     * Delete a file
     *
     * @var fileToDelete
     * @var index
     */
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
            RegistrationHelper::updateReportCardsName($fileName);
        }
    }

    /**
     * Get the real filename of a file
     *
     * @var file_name
     * @var studentFullName
     */
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

    /**
     * Get the files names
     */
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

    /**
     * Move a file from his path to his new path
     * @var currentPath
     * @var newPath
     */
    public static function moveFile($currentPath, $newPath)
    {
        Storage::disk(config('const.source_disk'))->move($currentPath, $newPath);
    }

    /**
     * Get student files
     * @var student
     */
    public static function getStudentFiles($student)
    {
        return Storage::disk(config('const.source_disk'))->files($student->folderPath());
    }

    /**
     * Get the content of a file
     * @var student
     */
    public static function getFileContent($file)
    {
        return Storage::disk(config('const.source_disk'))->get($file);
    }
}
