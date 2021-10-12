<?php

use Illuminate\Support\Facades\Route;

Route::get('/', "EventController@index");

Route::post('/create', "EventController@create");

Route::get('/calendar/{idCalendar}/{date}', "EventController@index");

Route::get('/worker', "EventController@indexWorker");

Route::post('/worker/select', "EventController@select");

Route::get('/worker/{idCalendar}/{date?}', "EventController@indexWorker");

//
//Route::post('/worker/{id}', "EventController@showWorker");
//
//Route::post('/worker/show', "EventController@showWorkerForm");
//
//Route::post('/worker/show/{id}', "EventController@showWorker");
//
