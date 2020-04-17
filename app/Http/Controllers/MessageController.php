<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\MessageHelper;

class MessageController extends Controller
{
    public function index()
    {
        if (session()->has('student')) {
            $data = MessageHelper::getStudentMessageInfo();
        } else if (session()->has('teacher')) {
            $data = MessageHelper::getTeacherMessageInfo();
        } else {
            return redirect('/');
        }

        return view('discussion.index', compact(["data"]));
    }

    public function add(Request $request)
    {
        $messageContent = $request->content;
        return MessageHelper::addStudentMessage($messageContent);
    }

    public function addTeacherResponse(Request $request)
    {
        $studentId = $request->student_id;
        $responseContent =  $request->content;
    
        return MessageHelper::addTeacherResponse($studentId, $responseContent);
    }

    public function getStudentMessage(Request $request)
    {
        if (session()->has('teacher')) {
            $studentId = $request->studentId;
            return MessageHelper::getStudentMessage($studentId);
        } else {
            return redirect('/');
        }
    }
}
