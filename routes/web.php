<?php

use Illuminate\Support\Facades\Route;


/* Index */

Route::get('/', function () {
    if (session()->has('student')) {
        return redirect()->action('RegistrationController@index');
    } else if (session()->has('teacher')) {
        return redirect()->action('RegistrationStudyController@index');
    }
    return view('index');
});


/* Log */
Route::post('/Login', 'LogController@logIn');
Route::post('/Logout', 'LogController@logOut');


/* Profile */
Route::get('/Profile', function () {
    if (session('student')) {
        return view('student.profile');
    } else if (session('teacher')) {
        return view('teacher.profile');
    }
    return redirect('/');
});


/* Students */
Route::post('/Student/Add', 'StudentController@add');
Route::post('/Student/Update', 'StudentController@update');
Route::post('/Student/GetStudentInfo', 'StudentController@getInfo');


/* Teacher */
Route::post('/Teacher/Add', 'TeacherController@add');
Route::post('/Teacher/Update', 'TeacherController@update');
Route::post('/Teacher/Delete', 'TeacherController@delete');


/* Registrations */
Route::get('/Registration', 'RegistrationController@index');
Route::post('/Registration/GetStepData', 'RegistrationController@getStepData');
Route::post('/Registration/SaveStepData', 'RegistrationController@saveStepData');
Route::get('/Registration/GetFile', 'RegistrationController@getFile');
Route::post('/Registration/DeleteFile', 'RegistrationController@deleteFile');
Route::post('/Registration/Complete', 'RegistrationController@complete');


/* RegistrationStudy */
Route::get('/RegistrationsStudy', 'RegistrationStudyController@index');
Route::post('/RegistrationsStudy/DownloadRegistration', 'RegistrationStudyController@downloadRegistration');
Route::post('/RegistrationsStudy/DownloadAllRegistrations', 'RegistrationStudyController@downloadAllRegistrations');
Route::post('/RegistrationsStudy/UpdateStatus', 'RegistrationStudyController@updateStatus');
Route::get('/RegistrationStudy/GetRegistrations', 'RegistrationStudyController@getRegistrations');


/* Message */
Route::get('/Discussion', 'MessageController@index');
Route::get('/Discussion/GetStudentMessage', 'MessageController@getStudentMessage');
Route::post('/Discussion/AddNewMessage', 'MessageController@add');
Route::post('/Discussion/AddTeacherResponse', 'MessageController@addTeacherResponse');