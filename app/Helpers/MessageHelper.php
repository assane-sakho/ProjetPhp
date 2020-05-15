<?php

namespace App\Helpers;

use App\Message;
use App\Student;
use Carbon\Carbon;

class MessageHelper
{
    /**
     * Get the messages of the connected student
     */
    public static function getStudentMessageInfo()
    {
        $student = auth()->guard('student')->user();

        $studentMessages = $student->messages;
        $lastMessage = $studentMessages->last();

        $formAction = "/Discussion/AddNewMessage";
        $labelText = 'Laisser un message à un professeur';
        $btnText = 'Envoyer';
        $canSend = 'true';

        if ($lastMessage !=null && $lastMessage->responseContent == null) {
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

    /**
     * Get the messages of a teacher
     */
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

    /**
     * Create a message in database
     * 
     * @var messageContent
     */
    public static function addStudentMessage($messageContent)
    {
        return Message::create([
            "student_id" => auth()->guard('student')->user()->id,
            "messageContent" => $messageContent,
            "messageDate" => Carbon::now()->format('Y-m-d H:i')
        ]);
    }

    /**
     * Add a response to a message in database
     * 
     * @var studentId
     * @var responseContent
     */
    public static function addTeacherResponse($studentId, $responseContent)
    {
        $message = Message::where([
            "student_id" => $studentId,
            "responseContent" => null,
            "responseDate" => null,
        ])->get()->last();

        if ($message == null) {
            return ResponseHelper::returnResponseError('noMessageFound');
        }

        $message->responseContent = $responseContent;
        $message->responseDate = Carbon::now()->format('Y-m-d H:i');
        $message->save();

        return $message;
    }

    /**
     * Get the message of a student
     * 
     * @var studentId
     */
    public static function getStudentMessage($studentId)
    {
        return  Student::find($studentId)->messages;
    }
}
