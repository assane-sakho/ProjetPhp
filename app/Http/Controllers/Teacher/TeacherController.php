<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\TeacherHelper;
use Illuminate\Support\Facades\View;

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

    public function profile()
    {
        return View::make('profile');
    }

    /**
     * Update a teacher
     */
    public function update(Request $request)
    {
        $email = $request->teacherEmail;
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
