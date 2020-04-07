<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Student;
use Carbon\Carbon;
use Response;

class MessageController extends Controller
{
    public function index()
    {
        $students = '';
        $studentMessages = '';
        $canSend = 'true';

        if (session()->has('student')) {
            $studentMessages = Message::where("student_id", session('student')->id)->get();
            $formAction = "/Discussion/AddNewMessage";
            $labelText ='Laisser un message à un professeur';
            $btnText ='Envoyer';

            $lastMessage = Message::whereNull(["responseContent", "responseDate"])->get()->sortByDesc('id')->first();
            if($lastMessage != null)
            {
                $canSend = 'false';
            }
        } else if (session()->has('teacher')) {
            $uniqueStudentIdMessage = Message::get('student_id')->unique('student_id')->pluck('student_id')->toArray();;
            $students= Student::whereIn('id', $uniqueStudentIdMessage )->get();
            $formAction = "/Discussion/AddTeacherResponse";
            $labelText ='Répondre à l\'élève';
            $btnText ='Répondre';
          
        } else {
            return view('index');
        }

        return view('discussion.index', compact([
            "canSend",
            "labelText",
            "btnText",
            "students",
            "studentMessages",
            "formAction",
        ]));
    }

    public function add(Request $request)
    {
        $message =  Message::create([
            "student_id" => session('student')->id,
            "messageContent" => $request->content,
            "messageDate" => Carbon::now()->format('Y-m-d H:i')
        ]);
        return $message;
    }

    public function addTeacherResponse(Request $request)
    {
        $message = Message::where([
            "student_id" => $request->student_id,
            "responseContent" => null,
            "responseDate" => null,
        ])->get()->sortByDesc('id')->first();
      
        if($message == null)
        {
            $returnData = array(
                'status' => 'error',
                'message' => 'noMessageFound'
            );
            $returnCode = 500;
            return Response::json($returnData, $returnCode);
        }

        $message->responseContent = $request->content;
        $message->responseDate = Carbon::now()->format('Y-m-d H:i');
        $message->save();
        return $message;
    }

    public function getStudentMessage(Request $request)
    {
        return  Message::where("student_id", $request->studentId)->get();
    }
}
