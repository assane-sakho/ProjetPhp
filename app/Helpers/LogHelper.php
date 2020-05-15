<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class LogHelper
{
    /**
     * Try to connect the user
     * 
     * @var email
     * @var password
     */
    public static function tryConnectUser($email, $password)
    {
        $user = [
            'email' => $email,
            'password' => $password
        ];

        if (!Auth::guard('student')->attempt($user)) {
            if (!Auth::guard('teacher')->attempt($user)) {
                return self::userNotConnected();
            }
            else
            {
                return self::connectTeacher();
            }
        }
        else
        {
            return self::connectStudent(auth()->guard('student')->user());
        }
    }

    /**
     * Connect the student
     * @var student
     */
    public static function connectStudent($student)
    {
        return ResponseHelper::returnResponseSuccess(['name' => $student->fullName(), 'nextLocation' => '/Registration']);
    }

    /**
     * Connect the teacher
     * @var teacher
     */
    public static function connectTeacher()
    {
        return ResponseHelper::returnResponseSuccess(['name' => 'Professeur', 'nextLocation' => '/RegistrationsStudy']);
    }

    /**
     * Return userNotConnected error
     * @var teacher
     */
    public static function userNotConnected()
    {
        return ResponseHelper::returnResponseError('userNotFound');
    }

    /**
     * Disconnect the user
     */
    public static function disconnectUser()
    {
        if (auth()->guard('student')->check()) {
            Auth::guard('student')->logout();
        } else {
            Auth::guard('teacher')->logout();
        }
    }
}
