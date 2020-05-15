<?php

use Illuminate\Support\Facades\Route;


/* Index */

Route::get('/', function () {
    if (auth()->guard('student')->check()) {
        return redirect()->route('registrationIndex');
    } else if (auth()->guard('teacher')->check()) {
        return redirect()->route('registrationsStudyIndex');
    }
    return view('index');
})->name('index');


/* Log */
Route::post('/Login', 'LogController@logIn');
Route::post('/Logout', 'LogController@logOut');


/* Profile */
Route::get('/Profile', function () {
    if (auth()->guard('student')->user()) {
        return redirect()->route('studentProfile');
    } else if (auth()->guard('teacher')->user()) {
        return view('teacher.profile');
    }
    return redirect('/');
});

Route::namespace('Student')->group(function () {

    /* Students */
    Route::post('/Student/Add', 'StudentController@add');
    Route::get('/Student/Profile', 'StudentController@profile')->name('studentProfile');
    Route::post('/Student/Update', 'StudentController@update');
    Route::post('/Student/GetStudentInfo', 'StudentController@getInfo');

    /* Registrations */
    Route::middleware(['auth:student'])->get('/Registration', 'RegistrationController@index')->name('registrationIndex');
    Route::middleware(['auth:student'])->post('/Registration/GetStepData', 'RegistrationController@getStepData');
    Route::middleware(['auth:student'])->post('/Registration/SaveStepData', 'RegistrationController@saveStepData');
    Route::middleware(['auth:teacher,student'])->get('/Registration/GetFile', 'RegistrationController@getFile');
    Route::middleware(['auth:student'])->post('/Registration/DeleteFile', 'RegistrationController@deleteFile');
    Route::middleware(['auth:student'])->post('/Registration/Complete', 'RegistrationController@complete');
});

Route::namespace('Teacher')->group(function () {

    /* RegistrationStudy */
    Route::get('/RegistrationsStudy', 'RegistrationStudyController@index')->name('registrationsStudyIndex');
    Route::post('/RegistrationsStudy/DownloadRegistration', 'RegistrationStudyController@downloadRegistration');
    Route::post('/RegistrationsStudy/downloadMultipleRegistrations', 'RegistrationStudyController@downloadMultipleRegistrations');
    Route::post('/RegistrationsStudy/UpdateStatus', 'RegistrationStudyController@updateStatus');
    Route::get('/RegistrationStudy/GetRegistrations', 'RegistrationStudyController@getRegistrations');

    /* Teacher */
    Route::post('/Teacher/Add', 'TeacherController@add');
    Route::post('/Teacher/Update', 'TeacherController@update');
    Route::post('/Teacher/Delete', 'TeacherController@delete');
});

/* Message */
Route::middleware(['auth:teacher,student'])->get('/Discussion', 'MessageController@index');
Route::middleware(['auth:teacher'])->get('/Discussion/GetStudentMessage', 'MessageController@getStudentMessage');
Route::middleware(['auth:student'])->post('/Discussion/AddNewMessage', 'MessageController@add');
Route::middleware(['auth:teacher'])->post('/Discussion/AddTeacherResponse', 'MessageController@addTeacherResponse');
