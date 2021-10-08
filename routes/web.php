<?php

use Illuminate\Support\Facades\Route;

Route::get('/', "EventController@index");

Route::post('/create', "EventController@create");

Route::get('/calendar/{idCalendar}/{date}', "EventController@index");

Route::get('/worker', "EventController@indexWorker");

Route::get('/worker/{idCalendar}/{date}', "EventController@indexWorker");
