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

    public static function updateStatus($registrationId, $registrationStatusId)
    {
        $registration = Registration::find($registrationId);
        $registration->status_id = $registrationStatusId;
        $registration->save();
    }

    public static function downloadZip($fileName, $student = null)
    {
        $basePath = storage_path('app/registrations/');
        Storage::makeDirectory('registrations');

        $filePath = $basePath . $fileName;

        if ($student != null) {
            $zip = new Filesystem(new ZipArchiveAdapter($filePath));

            $files = FileHelper::getStudentFile($student);

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

    public static function downloadAllRegistration($registrations)
    {
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

    public static function getData()
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
}
