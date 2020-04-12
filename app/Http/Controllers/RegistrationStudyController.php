<?php

namespace App\Http\Controllers;

use App\Registration;
use App\RegistrationStatus;
use App\Student;
use App\Training;

use Illuminate\Http\Request;
use App\Helpers\FolderHelper;

use Response;
use Carbon;

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

    public function editStatus(Request $request)
    {
        $registrationId = $request->registrationId;
        $registration = Registration::find($registrationId);

        $registrationStatusId = $request->registrationStatus;
        $registration->status_id = $registrationStatusId;
        $registration->save();
    }

    function downloadRegistration(Request $request)
    {
        $studentId = $request->student_id;
        $student = Student::find($studentId);

        $fileName = 'Candidature ' . $student->registration->training->name . ' - ' . $student->fullName() . '.zip';

        return FolderHelper::downloadZip($fileName, $student);
    }

    function downloadAllRegistrations(Request $request)
    {
        $registration_status = $request->registration_status_d;
        $training_d = $request->training_d;
        $today = Carbon\Carbon::now()->format('Y-m-d');

        $registrations = $this->getRegistrationsToDownload($registration_status, $training_d);

        if ($registrations->count() == 0) {
            $returnData = array(
                'status' => 'error',
                'message' => 'noRegistration'
            );
            $returnCode = 500;
            return Response::json($returnData, $returnCode);
        }

        foreach ($registrations as $registration) {
            $student = $registration->student;
            $fileName = 'Candidature ' . $student->registration->training->name . ' - ' . $student->fullName() . '.zip';
            FolderHelper::downloadZip($fileName, $student);
        }
        $fileName = 'Candidatures ' .  $today . '.zip';
        FolderHelper::deleteFile($fileName);
        return FolderHelper::downloadZip($fileName);
    }

    function getRegistrationsToDownload($registration_status, $training_d)
    {
        if ($registration_status == "all") {
            $registrations = Registration::where("status_id", '!=', "1");
        } else {
            $registrations = Registration::where("status_id", $registration_status);
        }

        if ($training_d != "all") {
            $registrations = $registrations->where("training_id", $training_d)->get();
        } else {
            $registrations = $registrations->get();
        }

        return $registrations;
    }
}
