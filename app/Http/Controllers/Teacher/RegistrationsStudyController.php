<?php

namespace App\Http\Controllers\Teacher;

use App\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;

use App\Helpers\RegistrationsStudyHelper;
use App\Helpers\RegistrationHelper;
use App\Helpers\ResponseHelper;


class RegistrationsStudyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }

    public function index()
    {
        $data = RegistrationsStudyHelper::getAllRegistrationsData();
        return View::make('registrationsStudy.index')->with($data);
    }

    /**
     *  Get the registrations data for the live searching datatable
     */
    public function getRegistrations(Request $request)
    {
        $draw = $request->draw;
        $searchValue = $request->search['value'];
        $start = $request->start;
        $length = $request->length;
        $orderColumn = $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];

        $training_id = $request->training_id;
        $status_id = $request->status_id;

        return RegistrationsStudyHelper::getRegistrationsDataTables($draw, $searchValue, $start, $length, $orderColumn, $orderDir, $training_id, $status_id);
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

        RegistrationsStudyHelper::recreateRegistrationDir();
        return RegistrationsStudyHelper::downloadZip($fileName, $student);
    }

    /**
     *  Download multiple registrations
     */
    function downloadMultipleRegistrations(Request $request)
    {
        $registration_status = $request->registration_status_d;
        $training_d = $request->training_d;
        $trainingType = $request->trainingType;

        $registrations = RegistrationsStudyHelper::getRegistrationsToDownload($registration_status, $training_d, $trainingType);

        if ($registrations->count() == 0) {
            return ResponseHelper::returnResponseError('noRegistration');
        }
        return RegistrationsStudyHelper::downloadMultipleRegistrations($registrations);
    }
}
