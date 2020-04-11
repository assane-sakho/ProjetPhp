<?php

namespace App\Helpers;

use App\Student;

class StudentHelper
{
    public static function checkIfStudentExist($email, $password)
    {
        $result = true;

        $student = Student::where([
            'email' => $email,
            'password' => $password
        ])->first();

        if($student == null)
        {
            $result = false;
        }
        return array($result, $student);
    }
}