<?php

use Illuminate\Support\Facades\Route;


/* Index */

Route::get('/', function () {
    if (session('student')) {
        return view('registration.index');
    } else if (session('teacher')) {
        return view('registrationStudy.index');
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
    return view('index');
});


/* Students */
Route::post('/Student/Add', 'StudentController@add');
Route::post('/Student/Update', 'StudentController@Update');


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
