<?php

use Illuminate\Support\Facades\Route;

/* Index */
Route::get('/', function () {
    if(session('student'))
    {
        return view('registration.index');
    } 
    else if(session('teacher'))
    {
        return view('registrationStudy.index');
    }
    return view('index');
});

/* Students */
Route::post('/Student/Add', 'StudentController@add');
Route::post('/Student/Update', 'StudentController@Update');


/* Log */
Route::post('/Login', 'LogController@logIn');
Route::post('/Logout', 'LogController@logOut');


/* Registrations */
Route::get('/Registration', 'RegistrationController@index');
Route::post('/Registration/GetStepData', 'RegistrationController@getStepData');
Route::post('/Registration/SaveStepData', 'RegistrationController@saveStepData');
Route::get('/Registration/GetFile', 'RegistrationController@getFile');
Route::post('/Registration/DeleteFile', 'RegistrationController@deleteFile');
Route::post('/Registration/Complete', 'RegistrationController@complete');

/* RegistrationStudy */
Route::get('/RegistrationsStudy', 'RegistrationStudyController@index');
Route::get('/RegistrationsStudy/Get', 'RegistrationStudyController@getRegistration');
Route::post('/RegistrationsStudy/DownloadRegistration', 'RegistrationStudyController@downloadRegistration');
Route::post('/RegistrationsStudy/DownloadAllRegistrations', 'RegistrationStudyController@downloadAllRegistrations');


/* Profile */
Route::get('/Profile', function () {
    if(session('student'))
    {
        return view('student.profile');
    } 
    else if(session('teacher'))
    {
        return view('teacher.profile');
    }
    return view('index');
});