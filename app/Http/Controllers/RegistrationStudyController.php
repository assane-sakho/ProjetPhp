<?php

namespace App\Http\Controllers;

use App\Registration;
use App\RegistrationStatus;
use Illuminate\Http\Request;
use App\Helpers\FoldersFiles as HelpersFoldersFiles;
use App\Student;

class RegistrationStudyController extends Controller
{
    public function index()
    {
        $data =  array();
        
        $registrations = Registration::all();
        $statuses = RegistrationStatus::where("id", '!=', 1)->get();
        return view('registrationsStudy.index', compact([
            "registrations", "registrations",
            "statuses", "statuses",
        ]));
    }

    function downloadRegistration(Request $request)
    {
        $studentId = $request->student_id;
        $student = Student::find($studentId);

        $fileName = 'Candidature_' . $student->registration->training->name . '_' . $student->lastname . '-' . $student->firstname . '.zip';
        HelpersFoldersFiles::deleteFile($fileName);
        
        return HelpersFoldersFiles::downloadZip($studentId, $fileName);
    }
}
