<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;
use App\Teacher;
use Response;

class LogController extends Controller
{
    public function logIn(Request $request)
    {
        $login = $request->userLoginMail;
        $password = $request->userLoginPassword;

        $student = Student::where([
            'email' => $login,
            'password' => $password
        ])->first();

        if($student == null)
        {
            $teacher = Teacher::where([
                'email' => $login,
                'password' => $password
            ])->first();

            if($teacher == null)
            {
                $returnData = array(
                    'status' => 'error',
                    'message' => 'userNotFound'
                );
                $returnCode = 500;
            }
            else
            {
                $request->session()->put('teacher', $teacher);

                $returnData = array(
                    'status' => 'success',
                    'name' => 'Professeur',
                    'nextLocation' => '/RegistrationsStudy',
                );
                $returnCode = 200;
            }    
        }
        else
        {                    
            $registrationStatusId = $student->registration->status_id ;
            $isRegistrationComplete = $registrationStatusId != 1 && $registrationStatusId != 3;

            $request->session()->put('student', $student);
            $request->session()->put('isRegistrationComplete', $isRegistrationComplete);

            $returnData = array(
                'status' => 'success',
                'name' => $student->firstname . ' ' . $student->lastname ,
                'nextLocation' => '/Registration',
            );
            $returnCode = 200;
        }
        return Response::json($returnData, $returnCode);
    }

    public function logOut(Request $request)
    {
        $request->session()->forget('student');
        $request->session()->forget('isRegistrationComplete');

        $request->session()->forget('teacher');

        return view('index');
    }
}
