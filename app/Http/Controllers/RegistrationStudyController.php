<?php

namespace App\Http\Controllers;

use App\Registration;
use App\RegistrationStatus;
use Illuminate\Http\Request;
use App\Helpers\FoldersFiles as HelpersFoldersFiles;
use App\Student;
use Response;

class RegistrationStudyController extends Controller
{
    public function index()
    {
        if (session()->has('teacher')) {
            $data =  array();

            $registrations = Registration::all();
            $statuses = RegistrationStatus::where("id", '!=', 1)->get();
            return view('registrationsStudy.index', compact([
                "registrations", "registrations",
                "statuses", "statuses",
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

        $fileName = 'Candidature_' . $student->registration->training->name . '_' . $student->lastname . '-' . $student->firstname . '.zip';
        HelpersFoldersFiles::deleteFile($fileName);

        return HelpersFoldersFiles::downloadZip($studentId, $fileName);
    }

    function downloadAllRegistrations(Request $request)
    {
        HelpersFoldersFiles::cleanDirectory(storage_path() . '/registrations');

        $registrationStatus = $request->registration_status_d;

        if ($registrationStatus == "all") {
            $registrations = Registration::where("status_id", '!=', "1")->get();
        } else {
            $registrations = Registration::where("status_id", $registrationStatus)->get();
        }

        if($registrations->count() == 0)
        {
            $returnData = array(
                'status' => 'error',
                'message' => 'noRegistration'
            );
            $returnCode = 500;
            return Response::json($returnData, $returnCode);
        }

        foreach ($registrations as $registration) {
            $student = $registration->student;
            $fileName = 'Candidature_' . $student->registration->training->name . '_' . $student->lastname . '-' . $student->firstname . '.zip';
            HelpersFoldersFiles::downloadZip($student->id, $fileName);
        }
        return HelpersFoldersFiles::downloadZip($student->id, null);
    }
}
