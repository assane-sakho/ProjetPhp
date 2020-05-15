<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\MessageHelper;

class MessageController extends Controller
{
    public function index()
    {
        if (auth()->guard('student')->check()) {
            $data = MessageHelper::getStudentMessageInfo();
        } else {
            $data = MessageHelper::getTeacherMessageInfo();
        }
        return view('discussion.index', compact(["data"]));
    }

    /**
     * Add a message
     */
    public function add(Request $request)
    {
        $messageContent = $request->content;
        return MessageHelper::addStudentMessage($messageContent);
    }

    /**
     * Add a response to a message
     */
    public function addTeacherResponse(Request $request)
    {
        $studentId = $request->student_id;
        $responseContent =  $request->content;

        return MessageHelper::addTeacherResponse($studentId, $responseContent);
    }

    /**
     * Get the messages of a student
     */
    public function getStudentMessage(Request $request)
    {
        $studentId = $request->studentId;
        return MessageHelper::getStudentMessage($studentId);
    }
}
