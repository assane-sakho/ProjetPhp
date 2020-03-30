<?php

use Illuminate\Support\Facades\Route;

/* Index */
Route::get('/', function () {
    return view('index');
});

/* Student */
Route::get('/Student/Add', 'StudentController@add');