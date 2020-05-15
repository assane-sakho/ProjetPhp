<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;

use App\Helpers\FileHelper;
use App\Helpers\RegistrationHelper;
use App\Helpers\StudentHelper;

use App\Registration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student')->except(['getFile']);
    }

    public function index()
    {
        $student = StudentHelper::getConnectedStudent();
        $studentRegistration = $student->registration;
        $stepNumber = $studentRegistration->lastStep;
        return View::make('registration.index')->with(compact('stepNumber', $stepNumber));
    }

    /**
     * Get a file
     */
    public function getFile(Request $request)
    {
        $fileWanted = $request->fileName;
        $index = $request->number;
        $studentId = $request->studentId;

        return FileHelper::getFile($fileWanted, $index, $studentId);
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
        $studentRegistration = Registration::find(StudentHelper::getConnectedStudent()->registration->id);
        $studentFolder = $studentRegistration->folder;

        $data = RegistrationHelper::getStepinfos()[$stepNumber];

        return View::make('registration.partials.' . $data['viewName'])->with(compact(["data", "stepNumber"]));
    }

    /**
     * Save the data of a step
     */
    public function saveStepData(Request $request)
    {
        $folderFiles = RegistrationHelper::getFileArray();
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
        $stepNumber = $request->step_number;
        RegistrationHelper::updateLastStep($stepNumber);
    }

    /**
     * Complete a registration
     */
    public function complete()
    {
        RegistrationHelper::completeRegistration();
    }
}
