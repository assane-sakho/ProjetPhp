<?php

namespace App\Http\Composers;

use Illuminate\View\View;

class ViewComposer
{
    public function compose(View $view)
    {
        $data = [];

        if (auth()->guard('teacher')->check()) {
            $teacher =  auth()->guard('teacher')->user();
            $isAdmin = $teacher->id == 1;
            $data['teacher'] = $teacher;
            $data['isAdmin'] = $isAdmin;
        }
        else if(auth()->guard('student')->check())
        {
            $student =  auth()->guard('student')->user();
            $registrationStatusId = $student->registration->status_id;
            $isRegistrationComplete = ($registrationStatusId != 1) && ($registrationStatusId != 3);
            $data['student'] = $student;
            $data['isRegistrationComplete'] = $isRegistrationComplete;
            $data['registrationStatusId'] = $registrationStatusId;
        }
        $view->with($data);
    }
}
