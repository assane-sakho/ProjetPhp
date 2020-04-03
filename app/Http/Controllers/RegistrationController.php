<?php

namespace App\Http\Controllers;

use App\Registration;
use App\Training;
use App\ReportCard;

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
        $uploadTitle = "";
        $acceptedFile = "";

        switch ($stepNumber) {
            case 0:
                $trainings = Training::all();
                return view('registration.partials._trainings', compact(["trainings", "trainings"]));
                break;
            case 1:
                $fileText = "CV";
                $inputName = "cv";
                $uploadTitle = "votre " . $fileText;
                break;
            case 2:
                $fileText = "Lettre de motivation";
                $inputName = "cover_letter";
                $uploadTitle = "votre " . lcfirst($fileText);
                break;
            case 3:
                $fileText = "Relevés de notes";
                $inputName = "report_card";
                $uploadTitle = "vos " . lcfirst($fileText);
                break;
            case 4:
                $fileText = "Imprime écran de l'ENT de l'année en cours";
                $inputName = "vle_screenshot";
                $uploadTitle = "votre " . lcfirst($fileText);
                $acceptedFile = "image/x-png, image/jpeg, ";
                break;
            case 5:
                return view('registration.partials._validation');
                break;
        }
        return view('registration.partials._fileUpload', compact(
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
        $studentId = $studentRegistration->student_id;
        $folder = $studentRegistration->folder;

        $files = array(
            "cv",
            "cover_letter",
            "vle_screenshot",
            "report_card",
        );

        foreach ($files as $input) {
            if ($request->has($input)) {
                $file = $request->file($input);
                $fileNname = $input . '.' . $file->getClientOriginalExtension();
                $image['filePath'] = $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/' . $studentId . '/', $fileNname);
                
                if ($input == "report_card") {
                    ReportCard::create(["name" => $fileNname, "folder_id" => $folder->id]);
                }
                else
                {
                    $folder[$input] = $fileNname;
                }
                $folder->save();
            }
        }

        if ($request["training"]) {
            $studentRegistration->training_id = $request["training"];
            $studentRegistration->save();
        }

        session()->pull('registration', $studentRegistration);
        session()->put('registration', $studentRegistration);
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
