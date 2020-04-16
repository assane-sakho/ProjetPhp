<?php

namespace App\Helpers;

use App\ReportCard;
use App\Training;

class RegistrationHelper
{
    public static function uploadFile($folderFile, $fileToUpload)
    {
        $student  = session('student');
        $studentFolder = $student->registration->folder;
        $reportCards = $studentFolder->report_cards;

        $fileName = $folderFile . '.' . $fileToUpload->getClientOriginalExtension();

        if (strpos($fileName, 'report_card_') !== false) {
            $fileName = 'report_card_' . count($reportCards) . '.' . $fileToUpload->getClientOriginalExtension();
            $reportCards->add(ReportCard::create(['name' => $fileName, 'folder_id' => $studentFolder->id]));
        } else {
            $oldFile = $studentFolder[$folderFile];
            FileHelper::deleteFile($oldFile, null);
            $studentFolder[$folderFile] = $fileName;
        }

        FileHelper::storeFile($fileToUpload, $fileName);

        $studentFolder->save();
        StudentHelper::updateSessionVar();
    }

    public static function updateTraining($training_id)
    {
        $student  = session('student');
        $studentRegistration =  $student->registration;

        $studentRegistration->training_id = $training_id;
        $studentRegistration->save();
    }

    public static function deleteReportCard($fileName)
    {
        $student  = session('student');
        $studentFolder = $student->registration->folder;

        ReportCard::where([
            'name' => $fileName,
            'folder_id' => $studentFolder->id
        ])->delete();

        StudentHelper::updateSessionVar();
    }

    public static function updateRegistrationName($fileDeleted)
    {
        $student  = session('student');
        $reportCards = $student->registration->folder->report_cards;
        $studentFolderPath = $student->folderPath();
        
        $idx = (explode('.pdf', explode('report_card_', $fileDeleted)[1])[0]) + 1;

        for ($i = $idx; $i < 3; $i++) {
            $currentFileName = 'report_card_' . $i . '.pdf';
            $newFileName = 'report_card_' . ($i -1) . '.pdf';

            $reportCard = $reportCards->where("name", $currentFileName)->first();

            if($reportCard != null)
            {
                $reportCard->name = $newFileName;
                $reportCard->save();

                $currentPath = $studentFolderPath . $currentFileName;
                $newPath = $studentFolderPath . $newFileName;

                FileHelper::moveFile($currentPath, $newPath);
            }
        }
        StudentHelper::updateSessionVar();
    }

    public static function getStepinfos()
    {
        $viewNameUpload = "_fileUpload";
        $viewNameReplace = "_fileReplace";
        $acceptedFile = "application/pdf";

        $student = session('student');
        $studentRegistration = $student->registration;
        $studentFolder = $studentRegistration->folder;

        $uploadsInfos = [
            0 => [
                "trainings" => Training::all(),
                "student_training_id" => $studentRegistration->training_id,
                "viewName" => "_trainings"
            ],
            1 => [
                "fileText" => "CV",
                "inputName" => "cv",
                "uploadTitle" => "votre CV",
                "acceptedFile" => $acceptedFile,
                "filesUploaded" => array($studentFolder->cv),
                "viewName" => $studentFolder->cv == null  ? $viewNameUpload : $viewNameReplace
            ],
            2 => [
                "fileText" => "Lettre de motivation",
                "inputName" => "cover_letter",
                "uploadTitle" => "votre lettre de motivation",
                "acceptedFile" => $acceptedFile,
                "filesUploaded" => array($studentFolder->cover_letter),
                "viewName" => $studentFolder->cover_letter == null  ? $viewNameUpload : $viewNameReplace
            ],
            3 => [
                "fileText" => "Relevé de note",
                "inputName" => "report_card",
                "uploadTitle" => "votre relevé de note",
                "acceptedFile" => $acceptedFile,
                "filesUploaded" => $studentFolder->report_cards->toArray(),
                "viewName" => "_reportCardUpload"
            ],
            4 => [
                "fileText" => "Imprime écran de l'ENT de l'année en cours",
                "inputName" => "vle_screenshot",
                "uploadTitle" => "votre imprime écran de l'ENT de l'année en cours",
                "filesUploaded" => array($studentFolder->vle_screenshot),
                "acceptedFile" => "image/x-png, image/jpeg",
                "viewName" => $studentFolder->vle_screenshot == null  ? $viewNameUpload : $viewNameReplace
            ],
            5 => [
                "viewName" => "_validation"
            ]
        ];

        for ($i = 0; $i < count($uploadsInfos); $i++) {
            if (array_key_exists('filesUploaded', $uploadsInfos[$i])) {
                $uploadsInfos[$i]['filesUploaded'] = array_filter($uploadsInfos[$i]['filesUploaded']);
            }
        }
        return $uploadsInfos;
    }
}
