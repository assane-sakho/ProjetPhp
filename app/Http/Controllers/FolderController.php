<?php

namespace App\Http\Controllers;

use App\Folder;
use App\RegistrationStatus;
use Illuminate\Http\Request;
use SSP;

class FolderController extends Controller
{
    public function index()
    {
        $statuses = RegistrationStatus::where("id", '!=', 1)->get();
        return view('folders.index', compact([
            "statuses", "statuses",
        ]));
    }

    public function get()
    {
        $folders = Folder::all();
        $data =  array();
        foreach ($folders as $folder) {
            $registration = $folder->registration;
            $student = $folder->registration->student;

            $tmp = array();

            $tmp[] = $folder->id;
            $tmp[] = $student->lastname;
            $tmp[] = $student->firstname;
            $tmp[] = $registration->training->name;
            $tmp[] = $registration->registration_status->title;
            $tmp[] = $registration->registration_status->id;

            $data[] = $tmp;
        }
        echo json_encode($data);
    }
}
