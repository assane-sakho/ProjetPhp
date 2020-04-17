<?php

namespace App\Helpers;

class LogHelper
{
    public static function tryConnectUser($email, $password)
    {
        $studentExistResult = StudentHelper::checkIfStudentExist($email, $password);
        $studentExist = $studentExistResult[0];
        $student = $studentExistResult[1];

        if ($studentExist == false) {
            $teacherExistResult = TeacherHelper::checkIfTeacherExist($email, $password);
            $teacherExist = $teacherExistResult[0];
            $teacher = $teacherExistResult[1];

            if ($teacherExist == false) {
                return self::userNotConnected();
            } else {
                return self::connectTeacher($teacher);
            }
        } else {
            return self::connectStudent($student);
        }
    }

    public static function connectStudent($student)
    {
        $registrationStatusId = $student->registration->status_id;
        $isRegistrationComplete = $registrationStatusId != 1 && $registrationStatusId != 3;

        session()->put('student', $student);
        session()->put('isRegistrationComplete', $isRegistrationComplete);

        return ResponseHelper::returnResponseSuccess(['name' => $student->fullName(), 'nextLocation' => '/Registration']);
    }

    public static function connectTeacher($teacher)
    {
        session()->put('teacher', $teacher);

        return ResponseHelper::returnResponseSuccess(['name' => 'Professeur', 'nextLocation' => '/RegistrationsStudy']);
    }

    public static function userNotConnected()
    {
        return ResponseHelper::returnResponseError('userNotFound');
    }

    public static function disconnectUser()
    {
        session()->forget('student');
        session()->forget('isRegistrationComplete');

        session()->forget('teacher');
    }
}
