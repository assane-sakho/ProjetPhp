<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;
use App\Teacher;
use Response;

class LoginController extends Controller
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
                $returnData = array(
                    'status' => 'success',
                    'name' => 'Professeur',
                    'nextLocation' => '/Folders',
                );
                $returnCode = 200;
            }    
        }
        else
        {
            $returnData = array(
                'status' => 'success',
                'name' => $student->firstname . ' ' . $student->lastname ,
                'nextLocation' => '/Registration',
            );
            $returnCode = 200;
        }
        return Response::json($returnData, $returnCode);
    }
}
