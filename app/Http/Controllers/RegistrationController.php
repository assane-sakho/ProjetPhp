<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\FileHelper;
use App\Helpers\RegistrationHelper;
use App\Http\Controllers\Controller;

use App\Registration;

class RegistrationController extends Controller
{
    public function index()
    {
        if (session()->has('student'))
            return view('registration.index');
        return redirect('/');
    }

    /**
     * Get a file
     */
    public function getFile(Request $request)
    {
        if (session()->has('student') || session()->has('teacher')) {
            $fileWanted = $request->fileName;
            $index = $request->number;
            $studentId = $request->studentId;

            return FileHelper::getFile($fileWanted, $index, $studentId);
        }
        return redirect('/');
    }

    /**
     * Delete a file
     */
    public function deleteFile(Request $request)
    {
        $fileToDelete = $request->fileName;
        $index = $request->number;

        FileHelper::deleteFile($fileToDelete, $index);
    }

    /**
     * Get the data of a step
     */
    public function getStepData(Request $request)
    {
        $stepNumber = $request->step_number;

        $studentRegistration = Registration::find(session('student')->registration->id);
        $studentFolder = $studentRegistration->folder;

        $data = RegistrationHelper::getStepinfos()[$stepNumber];

        return view('registration.partials.' . $data['viewName'], compact(["data", "stepNumber"]));
    }

    /**
     * Save the data of a step
     */
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
            $training = $request->training;
            $classicTraining = $request->classicTraining == 'on' ? 1 : 0;
            $apprenticeshipTraining = $request->apprenticeshipTraining == 'on' ? 1 : 0;

            RegistrationHelper::updateTraining($training, $classicTraining, $apprenticeshipTraining);
        }
    }

    /**
     * Complete a registration
     */
    public function complete()
    {
        RegistrationHelper::completeRegistration();
    }
}
