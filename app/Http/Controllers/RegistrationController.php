<?php

namespace App\Http\Controllers;

use App\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('registration.index');
    }
}
