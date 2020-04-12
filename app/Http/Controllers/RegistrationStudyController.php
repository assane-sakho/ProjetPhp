<?php

namespace App\Http\Controllers;

use App\Registration;
use App\RegistrationStatus;
use App\Student;
use App\Training;

use Illuminate\Http\Request;
use App\Helpers\RegistrationStudyHelper;
use App\Helpers\ResponseHelper;

class RegistrationStudyController extends Controller
{
    public function index()
    {
        if (session()->has('teacher')) {
            $registrations = Registration::all();
            $statuses = RegistrationStatus::where("id", '!=', 1)->get();
            $trainings = Training::all();

            return view('registrationsStudy.index', compact([
                "registrations",
                "statuses",
                "trainings"
            ]));
        }
        return view('errors.404');
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

        $registrations = RegistrationStudyHelper::getRegistrationsToDownload($registration_status, $training_d);

        if ($registrations->count() == 0) {
            return ResponseHelper::returnResponseError('noRegistration');
        }
        return RegistrationStudyHelper::downloadAllRegistration($registrations);
    }
}
