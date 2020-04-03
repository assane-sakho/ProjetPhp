<?php

use Illuminate\Support\Facades\Route;

/* Index */
Route::get('/', function () { 
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

/* Folders */
Route::get('/Folders', 'FolderController@index');

/* Profile */
Route::get('/Profile', 'StudentController@profile');