<?php

namespace App\Http\Controllers;

use App\Registration;
use App\Training;

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
        $studentRegistration = Registration::where(["student_id" => session('student')->id])->first();
        $uploadTitle ="";
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
                $inputName = "coverLetter";
                $uploadTitle = "votre " . lcfirst($fileText);
                break;
            case 3:
                $fileText = "Relevés de notes";
                $inputName = "reportCard";
                $uploadTitle = "vos " . lcfirst($fileText);
                break;
            case 4:
                $fileText = "Imprime écran de l'ENT de l'année en cours";
                $inputName = "vleScreenshot";
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
            ["acceptedFile", "acceptedFile"]
        ));
            
    }
}
