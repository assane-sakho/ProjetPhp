<?php

namespace App\Helpers;

use App\Message;
use App\Student;
use Carbon\Carbon;

class MessageHelper
{
    public static function getStudentMessageInfo()
    {
        $studentId = session('student')->id;
        
        $studentMessages = Message::where("student_id", $studentId)->get();

        $formAction = "/Discussion/AddNewMessage";
        $labelText = 'Laisser un message à un professeur';
        $btnText = 'Envoyer';
        $canSend = 'true';

        $lastMessage = Message::whereNull(["responseContent", "responseDate"])->get()->sortByDesc('id')->first();
        if ($lastMessage != null) {
            $canSend = 'false';
        }
        return [
            "studentMessages" => $studentMessages,
            "formAction" => $formAction,
            "labelText" => $labelText,
            "btnText" => $btnText,
            "canSend" => $canSend
        ];
    }

    public static function getTeacherMessageInfo()
    {
        $uniqueStudentIdMessage = Message::get('student_id')->unique('student_id')->pluck('student_id')->toArray();;
        $students = Student::whereIn('id', $uniqueStudentIdMessage)->get();
        $formAction = "/Discussion/AddTeacherResponse";
        $labelText = 'Répondre à l\'élève';
        $btnText = 'Répondre';

        return [
            "uniqueStudentIdMessage" => $uniqueStudentIdMessage,
            "students" => $students,
            "formAction" => $formAction,
            "labelText" => $labelText,
            "btnText" => $btnText
        ];
    }

    public static function addStudentMessage($messageContent)
    {
        return Message::create([
            "student_id" => session('student')->id,
            "messageContent" => $messageContent,
            "messageDate" => Carbon::now()->format('Y-m-d H:i')
        ]);
    }

    public static function addTeacherResponse($studentId, $responseContent)
    {
        $message = Message::where([
            "student_id" => $studentId,
            "responseContent" => null,
            "responseDate" => null,
        ])->get()->sortByDesc('id')->first();

        if ($message == null) {
            return ResponseHelper::returnResponseError('noMessageFound');
        }

        $message->responseContent = $responseContent;
        $message->responseDate = Carbon::now()->format('Y-m-d H:i');
        $message->save();

        return $message;
    }

    public static function getStudentMessage($studentId)
    {
       return  Message::where("student_id", $studentId)->get();
    }
}
