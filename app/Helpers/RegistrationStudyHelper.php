<?php

namespace App\Helpers;

use App\Training;
use App\Registration;
use App\RegistrationStatus;
use App\Teacher;

use File;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use ZipArchive;
use  Carbon;

class RegistrationStudyHelper
{

    /**
     * Get student files
     * @var student
     */
    public static function updateStatus($registrationId, $registrationStatusId)
    {
        $registration = Registration::find($registrationId);
        $registration->status_id = $registrationStatusId;
        $registration->save();
    }

    /**
     * Download a directory as .zip
     */
    public static function downloadZip($fileName, $student = null)
    {
        $basePath = storage_path('app/registrations/');

        $filePath = $basePath . $fileName;

        if ($student != null) {


            $zip = new Filesystem(new ZipArchiveAdapter($filePath));

            $files = FileHelper::getStudentFiles($student);

            foreach ($files as $file) {
                $currentFileName = FileHelper::getFileName($file,  $student->fullName());
                $fileContent = FileHelper::getFileContent($file);
                $zip->put($currentFileName, $fileContent);
            }
            $zip->getAdapter()->getArchive()->close();
        } else {

            $zip = new ZipArchive;
            if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {

                $files = File::files($basePath);

                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }

                $zip->close();
            } else {
                return ResponseHelper::returnResponseError();
            }
        }

        $headers = array(
            'Content-Type: application/zip',
            'Content-disposition: attachment; filename:`' . $fileName . '`'
        );
        return response()->download($filePath, $fileName, $headers);
    }

    /**
     * Retrieve the registrations to download according to the status, the training and the training type
     * 
     * @var registrations_status
     * @var training_d
     * @var trainingType
     */
    public static function getRegistrationsToDownload($registration_status, $training_d, $trainingType)
    {
        if ($registration_status == "all") {
            $registrations = Registration::where("status_id", '!=', "1");
        } else {
            $registrations = Registration::where("status_id",  $registration_status);
        }

        if ($training_d != "all") {
            $registrations = $registrations->where("training_id", $training_d);
        } else {
            $registrations = $registrations;
        }

        if ($trainingType == "classic") {
            $registrations = $registrations->where("classicTraining", "1");
        } else if ($trainingType == "apprenticeship") {
            $registrations = $registrations->where("apprenticeshipTraining", "1");
        }

        return $registrations->get();
    }

    /**
     * Download all the registrations
     * 
     * @var registrations
     */
    public static function downloadAllRegistration($registrations)
    {
        Storage::makeDirectory('registrations');

        $today = Carbon\Carbon::now()->format('Y-m-d');

        foreach ($registrations as $registration) {
            $student = $registration->student;
            $fileName = 'Candidature ' . $student->registration->training->name . ' - ' . $student->fullName() . '.zip';
            self::downloadZip($fileName, $student);
        }
        $fileName = 'Candidatures ' .  $today . '.zip';
        @unlink(storage_path('app/registrations/' . $fileName));
        return self::downloadZip($fileName);
    }

    /**
     * Get the registrations datas
     * 
     * @var registrations
     */
    public static function getAllRegistrationsData()
    {
        $registrations = Registration::all();
        $statuses = RegistrationStatus::where("id", '!=', 1)->get();
        $trainings = Training::all();
        $teachers = Teacher::where("email", "!=", config('const.admin'))->get();

        return [
            "registrations" => $registrations,
            "statuses" => $statuses,
            "trainings" => $trainings,
            "teachers" => $teachers,
        ];
    }

    /**
     *  Get the registrations data for the live searching datatable
     * 
     * @var registrations
     */
    public static function getRegistrationsDataTables($draw, $searchValue, $start, $length, $orderColumn, $orderDir, $training_id, $status_id)
    {
        $orders = array(
            "0" => "id",
            "1" => "students.lastname",
            "2" => "students.firstname",
            "5" => "classicTraining",
            "6" => "apprenticeshipTraining",
        );

        $registrations = Registration::select([
            'registrations.*',
            'students.lastname as student_lastname',
            'students.firstname as student_firstname',
            'trainings.name as training_name',
            'registration_statuses.title as registration_status',
            'registration_statuses.id as registration_status_id',
        ])->join('students', 'students.registration_id', '=', 'registrations.id')
            ->leftjoin('trainings', 'trainings.id', '=', 'registrations.training_id')
            ->join('registration_statuses', 'registration_statuses.id', '=', 'registrations.status_id');

        $totalRecords = count($registrations->get());

        if ($searchValue != null) {
            $registrations = $registrations->where('trainings.name', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('trainings.name', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('students.lastname', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('students.firstname', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('registration_statuses.title', 'LIKE', '%' . $searchValue . '%');
        }

        if ($training_id != null) {
            $registrations = $registrations->where('training_id', $training_id);
        }

        if ($status_id != null) {
            $registrations = $registrations->where('status_id', $status_id);
        }

        $registrations =
            $registrations->orderBy($orders[$orderColumn], $orderDir)
            ->paginate($start)
            ->take($length);

        $totalRecordwithFilter = count($registrations);
        $response = array(
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $registrations
        );

        return json_encode($response);
    }

    public static function recreateRegistrationDir()
    {
        Storage::deleteDirectory('registrations');
        Storage::makeDirectory('registrations');
    }
}
