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
        return view('folders.index');
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

/* Folders */
Route::get('/Folders', 'FolderController@index');
Route::get('/Folders/Get', 'FolderController@get');

/* Profile */
Route::get('/Profile', 'StudentController@profile');