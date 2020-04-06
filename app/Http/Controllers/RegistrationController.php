<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\FoldersFiles as HelpersFoldersFiles;
use App\Http\Controllers\Controller;

use App\Registration;
use App\Training;
use App\ReportCard;

class RegistrationController extends Controller
{
    public function index()
    {
        if (session()->has('student'))
            return view('registration.index');
        return view('errors.404');
    }

    public function getFile(Request $request)
    {
        if (session()->has('student'))
        {
            $studentFolder = Registration::find(session('student')->registration->id)->folder;

            if ($request->fileName != "report_card") {
                $fileName = $studentFolder[$request->fileName];
            } else {
                $fileName = $studentFolder->report_card[$request->number]->name;
            }
    
            return HelpersFoldersFiles::getFile($fileName);
        }
        return view('errors.404');
    }

    public function deleteFile(Request $request)
    {
        $studentFolder = Registration::find(session('student')->registration->id)->folder;

        if ($request->fileName != "report_card") {
            $fileName = $studentFolder[$request->fileName];
        } else {
            $fileName = $studentFolder->report_card[$request->number]->name;
        }
        ReportCard::where(['name' => $fileName, 'folder_id' => $studentFolder->id])->delete();
        HelpersFoldersFiles::deleteFile($fileName);
    }

    public function getStepData(Request $request)
    {
        $stepNumber = $request->step_number;
        $uploadTitle = "";
        $acceptedFile = "";
        $viewName = "fileUpload";
        $filesUploaded = array();
        $studentRegistration = Registration::find(session('student')->registration->id);
        $studentFolder = $studentRegistration->folder;

        switch ($stepNumber) {
            case 0:
                $trainings = Training::all();
                $student_training_id = $studentRegistration->training_id;
                return view('registration.partials._trainings', compact([
                    "trainings", "trainings",
                    "student_training_id", "student_training_id",
                ]));
                break;
            case 1:
                $fileText = "CV";
                $inputName = "cv";
                $uploadTitle = "votre " . $fileText;
                array_push($filesUploaded, $studentFolder->cv);
                break;
            case 2:
                $fileText = "Lettre de motivation";
                $inputName = "cover_letter";
                $uploadTitle = "votre " . lcfirst($fileText);
                array_push($filesUploaded, $studentFolder->cover_letter);
                break;
            case 3:
                $fileText = "Relevé de notes";
                $inputName = "report_card";
                foreach ($studentFolder->report_card as $report_card) {
                    array_push($filesUploaded, $report_card->name);
                }
                $viewName = "reportCardUpload";
                break;
            case 4:
                $fileText = "Imprime écran de l'ENT de l'année en cours";
                $inputName = "vle_screenshot";
                $uploadTitle = "votre " . lcfirst($fileText);
                $acceptedFile = "image/x-png, image/jpeg, ";
                array_push($filesUploaded, $studentFolder->vle_screenshot);
                break;
            case 5:
                return view('registration.partials._validation');
                break;
        }

        $filesUploaded = array_filter($filesUploaded);

        if (count($filesUploaded) == 1 && $inputName != "report_card") {
            $viewName = "fileReplace";
        }
        return view(
            'registration.partials._' . $viewName,
            compact([
                "filesUploaded", "filesUploaded",
                "inputName", "inputName",
                "fileText", "fileText",
                "uploadTitle", "uploadTitle",
                "acceptedFile", "acceptedFile",
                "stepNumber", "stepNumber"
            ])
        );
    }

    public function saveStepData(Request $request)
    {
        $studentRegistration = Registration::find(session('student')->registration->id);
        $studentFolder = $studentRegistration->folder;

        $report_cardCount = count($studentFolder->report_card);

        $files = array(
            "cv",
            "cover_letter",
            "vle_screenshot",
            "report_card_" . $report_cardCount,
        );

        foreach ($files as $input) {
            if ($request->has($input)) {
                $file = $request->file($input);
                $fileName = $input . '.' . $file->getClientOriginalExtension();
                HelpersFoldersFiles::saveFile($file, $fileName);

                if (($input == "report_card_" . $report_cardCount) && ($report_cardCount < 3) && (!$studentFolder->report_card->has($input))) {
                    ReportCard::create(["name" => $fileName, "folder_id" => $studentFolder->id]);
                } else {
                    $studentFolder[$input] = $fileName;
                }
            }
        }
        $studentFolder->save();
        if ($request->has("training")) {
            $studentRegistration->training_id = $request["training"];
            $studentRegistration->save();
        }
        session()->put('student', $studentRegistration->student);
    }

    public function complete()
    {
        $studentRegistration = session('student')->registration;
        $studentRegistration->status_id = 2;
        $studentRegistration->save();
        session()->put('student', $studentRegistration->student);
        session()->put('isRegistrationComplete', true);
    }
}
