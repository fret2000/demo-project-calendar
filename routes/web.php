<?php

use Illuminate\Support\Facades\DB;

Route::get('/', "Event@calendar");

Route::post('/create', "Event@create");

Route::get('/calendar/{id}/{date}', "Event@calendar");

Route::get('/worker', "Controller@worker");

Route::get('/worker/{date}', "Controller@worker");
