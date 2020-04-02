<?php

namespace App\Http\Controllers;

use App\Registration;
use App\Training;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $trainings = Training::all();
        return view('registration.index', compact(["trainings", "trainings"]));
    }
}
