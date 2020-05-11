<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\TeacherHelper;

class TeacherController extends Controller
{
    /**
     * Add a teacher
     */
    public function add(Request $request)
    {
        $email = $request->teacherEmail;
        $password = $request->teacherPassword;

        return TeacherHelper::tryAddTeacher($email, $password);
    }

    /**
     * Update a teacher
     */
    public function update(Request $request)
    {
        $email = $request->teacherEmail ?? session('teacher')->email;
        $password = $request->teacherPassword;

        return TeacherHelper::tryUpdateTeacher($email, $password);
    }

    /**
     * Delete a teacher
     */
    public function delete(Request $request)
    {
        $id = $request->teacherId;

        return TeacherHelper::deleteTeacher($id);
    }
}
