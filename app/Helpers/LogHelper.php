<?php

namespace App\Helpers;

use Response;

class LogHelper
{
    public static function connectTryConnectUser($email, $password)
    {
        $studentExistResult = StudentHelper::checkIfStudentExist($email, $password);
        $studentExist = $studentExistResult[0];
        $student = $studentExistResult[1];

        if ($studentExist == false) {
            $teacherExistResult = TeacherHelper::checkIfTeacherExist($email, $password);
            $teacherExist = $teacherExistResult[0];
            $teacher = $teacherExistResult[1];

            if ($teacherExist == false) {
                return LogHelper::userNotConnected();
            } else {
                return LogHelper::connectTeacher($teacher);
            }
        } else {
            return LogHelper::connectStudent($student);
        }
    }
  
    public static function connectStudent($student)
    {
        $registrationStatusId = $student->registration->status_id;
        $isRegistrationComplete = $registrationStatusId != 1 && $registrationStatusId != 3;

        session()->put('student', $student);
        session()->put('isRegistrationComplete', $isRegistrationComplete);

        $returnData = array(
            'status' => 'success',
            'name' => $student->firstname . ' ' . $student->lastname,
            'nextLocation' => '/Registration',
        );
        $returnCode = 200;
        return Response::json($returnData, $returnCode);
    }

    public static function connectTeacher($teacher)
    {
        session()->put('teacher', $teacher);

        $returnData = array(
            'status' => 'success',
            'name' => 'Professeur',
            'nextLocation' => '/RegistrationsStudy',
        );
        $returnCode = 200;
        return Response::json($returnData, $returnCode);
    }

    public static function userNotConnected()
    {
        $returnData = array(
            'status' => 'error',
            'message' => 'userNotFound'
        );
        $returnCode = 500;
        return Response::json($returnData, $returnCode);
    }
   
    public static function disconnectUser()
    {
        session()->forget('student');
        session()->forget('isRegistrationComplete');

        session()->forget('teacher');
    }
}
