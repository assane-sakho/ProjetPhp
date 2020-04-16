<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\TeacherHelper;

class TeacherController extends Controller
{
    public function add(Request $request)
    {
        $email = $request->teacherEmail;
        $password = $request->teacherPassword;

        return TeacherHelper::tryAddTeacher($email, $password);
    }

    public function update(Request $request)
    {
        $email = $request->teacherEmail ?? session('teacher')->email;
        $password = $request->teacherPassword;

        return TeacherHelper::tryUpdateTeacher($email, $password);
    }
}
