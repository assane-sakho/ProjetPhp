<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\FileHelper;
use App\Helpers\RegistrationHelper;
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
        if (session()->has('student')) {
            $fileWanted = $request->fileName;
            $index = $request->number;

            return FileHelper::getFile($fileWanted, $index);
        }
        return view('errors.404');
    }

    public function deleteFile(Request $request)
    {
        $fileToDelete = $request->fileName;
        $index = $request->number;

        FileHelper::deleteFile($fileToDelete, $index);
    }

    public function getStepData(Request $request)
    {
        $stepNumber = $request->step_number;

        $studentRegistration = Registration::find(session('student')->registration->id);
        $studentFolder = $studentRegistration->folder;

        $stepInfo = RegistrationHelper::getStepsnfo()[$stepNumber];

        $trainings = $stepInfo["trainings"] ?? null;
        $student_training_id = $stepInfo["student_training_id"] ?? null;
        $fileText = $stepInfo["fileText"] ?? null;
        $inputName = $stepInfo["inputName"] ?? null;
        $uploadTitle = $stepInfo["uploadTitle"] ?? null;
        $acceptedFile = $stepInfo["acceptedFile"] ?? null;
        $filesUploaded = $stepInfo["filesUploaded"] ?? null;
        $viewName = $stepInfo["viewName"];

        if ($filesUploaded != null) {
            $filesUploaded =  array_filter($filesUploaded);
        }

        return view(
            'registration.partials.' . $viewName,
            compact([
                "stepNumber", "trainings", "student_training_id", "fileText", "inputName", "uploadTitle", "acceptedFile", "filesUploaded",
            ])
        );
    }

    public function saveStepData(Request $request)
    {
        $folderFiles = FileHelper::getFileArray();
        foreach ($folderFiles as $folderFile) {
            if ($request->has($folderFile)) {
                $fileToUpload = $request->file($folderFile);
                RegistrationHelper::uploadFile($folderFile, $fileToUpload);
            }
        }

        if ($request->has('training')) {
            RegistrationHelper::updateTraining($request["training"]);
        }
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
