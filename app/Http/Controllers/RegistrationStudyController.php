<?php

namespace App\Http\Controllers;

use App\Student;

use Illuminate\Http\Request;
use App\Helpers\RegistrationStudyHelper;
use App\Helpers\ResponseHelper;

class RegistrationStudyController extends Controller
{
    public function index()
    {
        if (session()->has('teacher')) {

            $data = RegistrationStudyHelper::getData();
            return view('registrationsStudy.index', compact(["data"]));
        }
        return redirect('/');
    }

    public function updateStatus(Request $request)
    {
        $registrationId = $request->registrationId;
        $registrationStatusId = $request->registrationStatus;
        RegistrationStudyHelper::updateStatus($registrationId, $registrationStatusId);
    }

    function downloadRegistration(Request $request)
    {
        $studentId = $request->student_id;
        $student = Student::find($studentId);

        $fileName = 'Candidature ' . $student->registration->training->name . ' - ' . $student->fullName() . '.zip';

        return RegistrationStudyHelper::downloadZip($fileName, $student);
    }

    function downloadAllRegistrations(Request $request)
    {
        $registration_status = $request->registration_status_d;
        $training_d = $request->training_d;
        $trainingType = $request->trainingType;

        $registrations = RegistrationStudyHelper::getRegistrationsToDownload($registration_status, $training_d, $trainingType);

        if ($registrations->count() == 0) {
            return ResponseHelper::returnResponseError('noRegistration');
        }
        return RegistrationStudyHelper::downloadAllRegistration($registrations);
    }
}
