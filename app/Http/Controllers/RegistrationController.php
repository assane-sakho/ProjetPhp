<?php

namespace App\Http\Controllers;

use App\Registration;
use App\Training;
use App\ReportCard;
use App\Folder;
use Response;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('registration.index');
    }

    public function getStepData(Request $request)
    {
        $stepNumber = $request->step_number;

        $studentRegistration = session('registration');
        $studentFolder = session('folder');

        $uploadTitle = "";
        $acceptedFile = "";
        $viewName = "fileUpload";
        $report_cardInputName = "report_card_" . count($studentFolder->report_card);

        $filesUploaded = array();

        switch ($stepNumber) {
            case 0:
                $trainings = Training::all();
                return view('registration.partials._trainings', compact(["trainings", "trainings"]));
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
                $fileText = "Relevés de notes";
                $inputName = "report_card_" . count(session('folder')->report_card);
                $uploadTitle = "vos " . lcfirst($fileText);
                foreach ($studentFolder->report_card as $report_card) {
                    array_push($filesUploaded, $report_card->name);
                }
                break;
            case 4:
                $fileText = "Imprime écran de l'ENT de l'année en cours";
                $inputName = "vle_screenshot";
                $uploadTitle = "votre " . lcfirst($fileText);
                $acceptedFile = "image/x-png, image/jpeg, ";
                $filesUploaded[] = $studentFolder->vle_screenshot;
                break;
            case 5:
                return view('registration.partials._validation');
                break;
        }
        $filesUploaded = array_filter($filesUploaded);
        if (count($filesUploaded) == 1 && $inputName != $report_cardInputName || ($inputName == $report_cardInputName && count($filesUploaded) == 3)) {
            $viewName = "fileReplace";
        }

        return view('registration.partials._' . $viewName, compact(
            ["filesUploaded", "filesUploaded"],
            ["inputName", "inputName"],
            ["fileText", "fileText"],
            ["uploadTitle", "uploadTitle"],
            ["acceptedFile", "acceptedFile"],
            ["stepNumber", "stepNumber"]
        ));
    }

    public function saveStepData(Request $request)
    {
        $studentRegistration = session('registration');
        $studentFolder = session('folder');

        $studentId = $studentRegistration->student_id;
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

                if (($input == "report_card_" . $report_cardCount) && ($report_cardCount < 3) && (!$studentFolder->report_card->has($input))) {
                    ReportCard::create(["name" => $fileName, "folder_id" => $studentFolder->id]);
                    $studentFolder = Folder::find($studentFolder->id);
                } else {
                    $studentFolder[$input] = $fileName;
                }

                $image['filePath'] = $file->getClientOriginalName();
                $file->move(storage_path() . '/uploads/' . $studentId . '/', $fileName);
                $studentFolder->save();
            }
        }

        if ($request["training"]) {
            $studentRegistration->training_id = $request["training"];
            $studentRegistration->save();
        }

        session()->pull('registration', $studentRegistration);
        session()->put('registration', $studentRegistration);

        session()->pull('folder', $studentFolder);
        session()->put('folder', $studentFolder);
    }

    public function getFile(Request $request)
    {
        $studentRegistration = session('registration');
        $studentFolder = session('folder');
        $studentId = $studentRegistration->student_id;


        if ($request->fileName != "report_card") {
            $fileName = $studentFolder[$request->fileName];
        } else {
            $fileName = $studentFolder->report_card[$request->number]->name;
        }

        $path = storage_path() . '/uploads/' . $studentId . '/' .  $fileName;

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }

    public function updateStatus($statusId)
    {
        $studentRegistration = session('registration');
        $studentRegistration->status_id = 1;
        $studentRegistration->save();

        session()->pull('registration', $studentRegistration);
        session()->put('registration', $studentRegistration);
    }
}
