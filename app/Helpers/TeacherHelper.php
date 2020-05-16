<?php

namespace App\Helpers;

use App\Teacher;

class TeacherHelper
{
    /**
     * Return true if an existing teacher corresponding to the email exist.
     *
     * @var email
     * @return boolean
     */
    public static function alreadyExist($email)
    {
        $teacherId = TeacherHelper::getConnectedTeacher()->id ?? '';

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
            return ResponseHelper::returnResponseSuccess();
        } else {
            return ResponseHelper::returnResponseError('emailAlreadyExist');
        }
    }

    /**
     * Update the connected teacher informations in database.
     *
     * @var email
     * @var password
     * @return teacher
     */
    public static function updateTeacher($email, $password)
    {
        $teacher = TeacherHelper::getConnectedTeacher();
        
        if ($email) {
            $teacher->email = $email;
        }
        if ($password) {
            $teacher->password = $password;
        }
        $teacher->save();
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

    public static function isTeacherConnected()
    {
        return  auth()->guard('teacher')->check();
    }

    public static function getConnectedTeacher()
    {
        return  auth()->guard('teacher')->user();
    }
}
