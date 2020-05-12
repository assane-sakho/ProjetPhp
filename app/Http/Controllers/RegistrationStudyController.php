<?php

namespace App\Http\Controllers;

use App\Student;

use Illuminate\Http\Request;
use App\Helpers\RegistrationStudyHelper;
use App\Helpers\RegistrationHelper;
use App\Helpers\ResponseHelper;

class RegistrationStudyController extends Controller
{
    public function index()
    {
        if (session()->has('teacher')) {

            $data = RegistrationStudyHelper::getAllRegistrationsData();
            return view('registrationsStudy.index', compact(["data"]));
        }
        return redirect('/');
    }

    /**
     *  Get the registrations data for the live searching datatable
     */
    public function getRegistrations(Request $request)
    {
        if (session()->has('teacher')) {

            $draw = $request->draw;
            $searchValue = $request->search['value'];
            $start = $request->start;
            $length = $request->length;
            $orderColumn = $request->order[0]['column'];
            $orderDir = $request->order[0]['dir'];

            $training_id = $request->training_id;
            $status_id = $request->status_id;

            return RegistrationStudyHelper::getRegistrationsDataTables($draw, $searchValue, $start, $length, $orderColumn, $orderDir, $training_id, $status_id);
        }
        return redirect('/');
    }

    /**
     *  Update a registration status
     */
    public function updateStatus(Request $request)
    {
        $registrationId = $request->registrationId;
        $registrationStatusId = $request->registrationStatus;

        RegistrationHelper::updateStatus($registrationId, $registrationStatusId);
    }

    /**
     *  Download the student registration
     */
    function downloadRegistration(Request $request)
    {
        $studentId = $request->student_id;
        $student = Student::find($studentId);

        $fileName = 'Candidature ' . $student->registration->training->name . ' - ' . $student->fullName() . '.zip';

        RegistrationStudyHelper::recreateRegistrationDir();
        return RegistrationStudyHelper::downloadZip($fileName, $student);
    }

    /**
     *  Download multiple registrations
     */
    function downloadMultipleRegistrations(Request $request)
    {
        $registration_status = $request->registration_status_d;
        $training_d = $request->training_d;
        $trainingType = $request->trainingType;

        $registrations = RegistrationStudyHelper::getRegistrationsToDownload($registration_status, $training_d, $trainingType);

        if ($registrations->count() == 0) {
            return ResponseHelper::returnResponseError('noRegistration');
        }
        return RegistrationStudyHelper::downloadMultipleRegistrations($registrations);
    }
}
