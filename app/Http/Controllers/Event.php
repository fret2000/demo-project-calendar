<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Event extends Controller
{
    public function calendar($date = null) {
        if ($date == null) {
            $date = date("Y-m-d");
        }

        $currentDate = strtotime($date);

        return view('calendar', collect([
            'date'=> $date,
            'currentDate' => $currentDate
        ]));
    }

    public function create(Request $request)
    {
        $data = array(
            'currentDate' => $request['currentDate'],
            'retryEvent' => $request['retryEvent'],
            'room' => $request['room'],
            'time_start' => $request['time_start'],
            'date_start' => $request['date_start'],
            'time_finish' => $request['time_finish'],
            'date_finish' => $request['date_finish'],
            'title' => $request['title']
        );
        var_dump("<pre>");
        var_dump($data);
    }

    public function gg(Request $request) {
        dd($request->all());
    }
}
