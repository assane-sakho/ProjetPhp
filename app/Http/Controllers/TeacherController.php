<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use Response;

class TeacherController extends Controller
{
    public function alreadyExist($email)
    {
        $teacherId = session('teacher')->id ?? '';

        $teachersExceptCurrent = Teacher::where('id', '!=', $teacherId)->get();

        $teachers = Teacher::where("email", $email)->get();
        $intersect = $teachers->intersect($teachersExceptCurrent);

        return ($intersect->count() >= 1);
    }

    public function add(Request $request)
    {
        $email = $request->teacherEmail;
        $password = $request->teacherPassword;

        if (!$this->alreadyExist($email)) {
            Teacher::create([
                "email" => $email,
                "password" => $password,
            ]);
            $returnData = array(
                'status' => 'success',
            );
            $returnCode = 200;
        } else {
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
        $email = $request->teacherEmail ?? session('teacher')->email;
        $password = $request->teacherPassword;

        if (!$this->alreadyExist($email)) {

            $teacher = Teacher::find(session('teacher')->id);

            $teacher->email = $email;
            if ($password != "") {
                $teacher->password = $email;
            }
            $teacher->save();
            $request->session()->pull('teacher', $teacher);
            $request->session()->put('teacher', $teacher);

            $returnData = array(
                'status' => 'success'
            );
            $returnCode = 200;
        } else {
            $returnData = array(
                'status' => 'error',
                'message' => 'emailAlreadyExist'
            );
            $returnCode = 500;
        }
        return Response::json($returnData, $returnCode);
    }
}
