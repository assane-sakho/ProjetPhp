<?php

use Illuminate\Support\Facades\Route;

/* Index */
Route::get('/', function () { 
    return view('loginRegister.index');
});


/* Students */
Route::post('/Student/Add', 'StudentController@add');


/* Login */
Route::post('/Login', 'LoginController@logIn');


/* Registrations */
Route::get('/Registration', 'RegistrationController@index');

/* Folders */
Route::get('/Folders', 'FolderController@index');