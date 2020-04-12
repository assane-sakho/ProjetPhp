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
        $report_cards = $studentFolder->report_cards;
        $report_cardsCount = count($report_cards);

        $nextReportCard =  "report_card_" . $report_cardsCount;

        $fileName = $folderFile . '.' . $fileToUpload->getClientOriginalExtension();
        $oldFile = $studentFolder[$folderFile];

        FileHelper::deleteFile($oldFile);
        FileHelper::storeFile($fileToUpload, $fileName);

        if ($folderFile == $nextReportCard && $report_cardsCount < 3 && !$studentFolder->report_cards->has($folderFile)) {
            $studentFolder->report_cards->add(ReportCard::create(['name' => $fileName, 'folder_id' => $studentFolder->id]));
        } else {
            $studentFolder[$folderFile] = $fileName;
        }
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

    public static function getStepsnfo()
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
                "filesUploaded" => array($studentFolder->report_cards->toArray()),
                "viewName" => "_reportCardUpload"
            ],
            4 => [
                "fileText" => "Imprime écran de l'ENT de l'année en cours",
                "inputName" => "vle_screenshot",
                "uploadTitle" => "votre imprime écran de l'ENT de l'année en cours",
                "filesUploaded" => array($studentFolder->vle_screenshot),
                "acceptedFile" => "image/x-png, image/jpeg",
                "viewName" => $studentFolder->vle_screenshoot == null  ? $viewNameUpload : $viewNameReplace
            ],
            5 => [
                "viewName" => "_validation"
            ]
        ];
        return $uploadsInfos;
    }
}
