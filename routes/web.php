<?php

use Illuminate\Support\Facades\Route;

Route::get('/', "EventController@index");

Route::post('/create', "EventController@create");

Route::get('/calendar/{date}', "Event@calendar");

Route::get('/worker', "Controller@worker");

Route::get('/worker/{date}', "Controller@worker");
