<?php

namespace App\Helpers;

use App\Teacher;

class TeacherHelper
{
    public static function checkIfTeacherExist($email, $password)
    {
        $result = true;

        $teacher = Teacher::where([
            'email' => $email,
            'password' => $password
        ])->first();

        if ($teacher == null) {
            $result = false;
        }
        return array($result, $teacher);
    }

    public static function alreadyExist($email)
    {
        $teacherId = session('teacher')->id ?? '';

        $teachersExceptCurrent = Teacher::where('id', '!=', $teacherId)->get();

        $teachers = Teacher::where("email", $email)->get();
        $intersect = $teachers->intersect($teachersExceptCurrent);

        return ($intersect->count() >= 1);
    }

    public static function tryAddTeacher($email, $password)
    {
        if (!TeacherHelper::alreadyExist($email)) {
           
            TeacherHelper::addTeacher($email, $password);

            return ResponseHelper::returnResponseSuccess();

        } else {
            return ResponseHelper::returnResponseError('emailAlreadyExist');
        }
    }

    public static function addTeacher($email, $password)
    {
        Teacher::create([
            "email" => $email,
            "password" => $password,
        ]);
    }

    public static function tryUpdateTeacher($email, $password)
    {
        if (!TeacherHelper::alreadyExist($email)) {

            TeacherHelper::updateTeacher($email, $password);

            return ResponseHelper::returnResponseSuccess();

        } else {
            return ResponseHelper::returnResponseError('emailAlreadyExist');
        }
    }

    public static function updateTeacher($email, $password)
    {
        $teacher = Teacher::find(session('teacher')->id);

        $teacher->email = $email;
        if ($password) {
            $teacher->password = $email;
        }
        $teacher->save();
        TeacherHelper::updateTeacherSessionVar();
    }

    public static function updateTeacherSessionVar()
    {
        $teacher = Teacher::find(session('teacher')->id);
        session()->put('teacher', $teacher);
    }
}
