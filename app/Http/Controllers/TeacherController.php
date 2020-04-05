<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use Response;

class TeacherController extends Controller
{
    public function alreadyExist($email)
    {
       return Teacher::where("email", $email)->count() == 1;
    }

    public function add(Request $request)
    {
        $email = $request->teacherEmail;
        $password = $request->teacherPassword;

        if(!$this->alreadyExist($email))
        {
            Teacher::create([
                "email" => $email,
                "password" => $password,
            ]);
            $returnData = array(
                'status' => 'error',
                'message' => 'emailNotPossible'
            );
            $returnCode = 500;
        }
        else
        {
            $returnData = array(
                'status' => 'error',
                'message' => 'emailAlreadyExist'
            );
            $returnCode = 500;
        }
        return Response::json($returnData, $returnCode);
    }

    public function update(Request $request)
    {
        $teacherId = $request->teacherId;
        $email = $request->teacherEmail;
        $password = $request->teacherPassword;

    
        if(!$this->alreadyExist($email))
        {
            $teacher = Teacher::find($teacherId);
            $teacher->email = $email;
            if($password != "")
            {
                $teacher->password = $email;
            }
            $teacher->save();
            
            $returnData = array(
                'status' => 'success'
            );
            $returnCode = 200;
        }
        else
        {
            $returnData = array(
                'status' => 'error',
                'message' => 'emailAlreadyExist'
            );
            $returnCode = 500;
        }
        return Response::json($returnData, $returnCode);
    }
}
