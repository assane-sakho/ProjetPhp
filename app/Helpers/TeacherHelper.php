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
        if(!self::emailValid($email)){
            return ResponseHelper::returnResponseError('emailNotPossible');
        }
        else if (!self::alreadyExist($email)) {
           
            $teacher = self::addTeacher($email, $password);

            return ResponseHelper::returnResponseSuccess(['teacherId' => $teacher->id]);

        } else {
            return ResponseHelper::returnResponseError('emailAlreadyExist');
        }
    }

    public static function addTeacher($email, $password)
    {
        return Teacher::create([
            "email" => $email,
            "password" => $password,
        ]);
    }

    public static function tryUpdateTeacher($email, $password)
    {
        if (!self::alreadyExist($email)) {

            self::updateTeacher($email, $password);

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
        self::updateTeacherSessionVar();
    }

    public static function updateTeacherSessionVar()
    {
        $teacher = Teacher::find(session('teacher')->id);
        session()->put('teacher', $teacher);
    }

    public static function deleteTeacher($id)
    {
        Teacher::find($id)->delete();
    }

    private static function emailValid($email)
    {
        $result = true;

        if($email == config('const.admin') || StudentHelper::alreadyExist($email)){
            $result = false;
        }

        return $result;
    }
}
