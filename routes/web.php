<?php

use Illuminate\Support\Facades\Route;

Route::get('/', "App\Http\Controllers\EventController@index");

Route::post('/create', "App\Http\Controllers\EventController@create");

Route::get('/calendar/{idCalendar}/{date}', "App\Http\Controllers\EventController@index");

Route::get('/worker', "App\Http\Controllers\EventController@indexWorker");

Route::get('/worker/{idCalendar}/{date}', "App\Http\Controllers\EventController@indexWorker");
