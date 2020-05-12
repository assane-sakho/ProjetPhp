<?php

namespace App\Helpers;

use App\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherHelper
{
    /**
     * Return the teacher corresponding to the email and password.
     *
     * @var email
     * @var password
     * @return array(result, teacher)
     */
    public static function checkIfTeacherExist($email, $password)
    {
        $result = true;

        $teacher = Teacher::where([
            'email' => $email
        ])->first();

        if ($teacher == null || !Hash::check($password, $teacher->password)) {
            $result = false;
        }
        return array($result, $teacher);
    }

    /**
     * Return true if an existing teacher corresponding to the email exist.
     *
     * @var email
     * @return boolean
     */
    public static function alreadyExist($email)
    {
        $teacherId = session('teacher')->id ?? '';

        $teachersExceptCurrent = Teacher::where('id', '!=', $teacherId)->get();

        $teachers = Teacher::where("email", $email)->get();
        $intersect = $teachers->intersect($teachersExceptCurrent);

        return ($intersect->count() >= 1);
    }

    /**
     * Try to add a teacher in database if they are not one with the email.
     *
     * @var email
     * @var password
     * @return jsonResponse
     */
    public static function tryAddTeacher($email, $password)
    {
        if (!self::emailValid($email)) {
            return ResponseHelper::returnResponseError('emailNotPossible');
        } else if (!self::alreadyExist($email) && !StudentHelper::alreadyExist($email)) {

            $teacher = self::addTeacher($email, $password);

            return ResponseHelper::returnResponseSuccess(['teacherId' => $teacher->id]);
        } else {
            return ResponseHelper::returnResponseError('emailAlreadyExist');
        }
    }

    /**
     * Create a teacher in database.
     *
     * @var email
     * @var password
     * @return teacher
     */
    public static function addTeacher($email, $password)
    {
        return Teacher::create([
            "email" => $email,
            "password" => $password,
        ]);
    }

    /**
     * Try to update the logged teacher in database if they are not one with the email.
     *
     * @var email
     * @var password
     * @return jsonResponse
     */
    public static function tryUpdateTeacher($email, $password)
    {
        if (!self::alreadyExist($email)) {
            self::updateTeacher($email, $password);
            self::updateTeacherSessionVar();
            return ResponseHelper::returnResponseSuccess();
        } else {
            return ResponseHelper::returnResponseError('emailAlreadyExist');
        }
    }

    /**
     * Update a teacher in database.
     *
     * @var email
     * @var password
     * @return teacher
     */
    public static function updateTeacher($email, $password)
    {
        $teacher = Teacher::find(session('teacher')->id);

        $teacher->email = $email;
        if ($password) {
            $teacher->password = $password;
        }
        $teacher->save();
    }

    /**
     * Update teacher session variables.
     *
     */
    public static function updateTeacherSessionVar()
    {
        $teacher = Teacher::find(session('teacher')->id);
        session()->put('teacher', $teacher);
    }

    /**
     * Delete a teacher in database.
     *
     * @var email
     * @var password
     * @return teacher
     */
    public static function deleteTeacher($id)
    {
        Teacher::find($id)->delete();
    }

    /**
     * Return true if the email is valid.
     *
     * @var email
     * @var password
     * @return teacher
     */
    private static function emailValid($email)
    {
        $result = true;

        if ($email == config('const.admin') || StudentHelper::alreadyExist($email)) {
            $result = false;
        }

        return $result;
    }
}
