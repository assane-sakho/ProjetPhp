<?php

use App\Helpers\StudentHelper;
use App\Helpers\TeacherHelper;
use Illuminate\Support\Facades\Route;


/* Index */

Route::get('/', function () {
    if (StudentHelper::isStudentConnected()) {
        return redirect()->route('registrationIndex');
    } else if (TeacherHelper::isTeacherConnected()) {
        return redirect()->route('registrationsStudyIndex');
    }
    return view('index');
})->name('index');


/* Log */
Route::post('/Login', 'LogController@logIn');
Route::post('/Logout', 'LogController@logOut');


/* Profile */
Route::middleware(['auth:teacher,student'])->get('/Profile', function () {
    if (StudentHelper::isStudentConnected()) {
        return redirect()->route('studentProfile');
    } else {
        return view('teacher.profile');
    }
});

Route::namespace('Student')->group(function () {

    /* Students */
    Route::post('/Student/Add', 'StudentController@add');
    Route::middleware(['auth:student'])->get('/Student/Profile', 'StudentController@profile')->name('studentProfile');
    Route::middleware(['auth:student'])->post('/Student/Update', 'StudentController@update');
    Route::middleware(['auth:student,teacher'])->get('/Student/GetStudentInfo', 'StudentController@getInfo');

    /* Registrations */
    Route::get('/Registration', 'RegistrationController@index')->name('registrationIndex');
    Route::post('/Registration/GetStepData', 'RegistrationController@getStepData');
    Route::post('/Registration/SaveStepData', 'RegistrationController@saveStepData');
    Route::middleware(['auth:teacher,student'])->get('/Registration/GetFile', 'RegistrationController@getFile')->name('getFile');
    Route::post('/Registration/DeleteFile', 'RegistrationController@deleteFile');
    Route::post('/Registration/Complete', 'RegistrationController@complete');
});

Route::namespace('Teacher')->group(function () {

    /* RegistrationStudy */
    Route::get('/RegistrationsStudy', 'RegistrationsStudyController@index')->name('registrationsStudyIndex');
    Route::post('/RegistrationsStudy/DownloadRegistration', 'RegistrationsStudyController@downloadRegistration');
    Route::post('/RegistrationsStudy/downloadMultipleRegistrations', 'RegistrationsStudyController@downloadMultipleRegistrations');
    Route::post('/RegistrationsStudy/UpdateStatus', 'RegistrationsStudyController@updateStatus');
    Route::get('/RegistrationStudy/GetRegistrations', 'RegistrationsStudyController@getRegistrations');

    /* Teacher */
    Route::post('/Teacher/Add', 'TeacherController@add');
    Route::get('/Teacher/Profile', 'TeacherController@profile')->name('teacherProfile');
    Route::post('/Teacher/Update', 'TeacherController@update');
    Route::post('/Teacher/Delete', 'TeacherController@delete');
});

/* Message */
Route::middleware(['auth:teacher,student'])->group(function () {

    Route::get('/Discussion', 'MessageController@index');
    Route::get('/Discussion/GetStudentMessage', 'MessageController@getStudentMessage')->name('getStudentMessage');
    Route::post('/Discussion/AddNewMessage', 'MessageController@add')->name('addMessage');
    Route::post('/Discussion/AddTeacherResponse', 'MessageController@addTeacherResponse')->name('addResponseMessage');
});
