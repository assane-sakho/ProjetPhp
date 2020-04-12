<?php

namespace App\Helpers;

use App\Registration;
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
            $source_disk = 's3';
            $files = Storage::disk($source_disk)->files($student->folderPath());

            foreach ($files as $file) {
                $currentFileName = FileHelper::getFileName($file,  $student->fullName());
                $fileContent = Storage::disk($source_disk)->get($file);
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
            }
        }

        $headers = array(
            'Content-Type: application/zip',
            'Content-disposition: attachment; filename:`' . $fileName . '`'
        );
        return response()->download($filePath, $fileName, $headers);
    }

    public static function getRegistrationsToDownload($registration_status, $training_d)
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

    public static function downloadAllRegistration($registrations)
    {
        $today = Carbon\Carbon::now()->format('Y-m-d');

        foreach ($registrations as $registration) {
            $student = $registration->student;
            $fileName = 'Candidature ' . $student->registration->training->name . ' - ' . $student->fullName() . '.zip';
            RegistrationStudyHelper::downloadZip($fileName, $student);
        }
        $fileName = 'Candidatures ' .  $today . '.zip';
        @unlink(storage_path('app/registrations/' . $fileName));
        return RegistrationStudyHelper::downloadZip($fileName);
    }
}
