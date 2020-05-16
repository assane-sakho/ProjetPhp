<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Helpers\StudentHelper;
use App\Helpers\TeacherHelper;

class ViewComposer
{
    public function compose(View $view)
    {
        $data = [];

        if (auth()->guard('teacher')->check()) {
            $teacher =  TeacherHelper::getConnectedTeacher();
            $isAdmin = $teacher->id == 1;
            $data['teacher'] = $teacher;
            $data['isAdmin'] = $isAdmin;
        }
        else if(auth()->guard('student')->check())
        {
            $student =  StudentHelper::getConnectedStudent();
            $registrationStatusId = $student->registration->status_id;
            $isRegistrationComplete = ($registrationStatusId != 1) && ($registrationStatusId != 3);
            $data['student'] = $student;
            $data['isRegistrationComplete'] = $isRegistrationComplete;
            $data['registrationStatusId'] = $registrationStatusId;
        }
        $view->with($data);
    }
}
