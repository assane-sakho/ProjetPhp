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

        if($teacher == null)
        {
            $result = false;
        }
        return array($result, $teacher);
    }
}