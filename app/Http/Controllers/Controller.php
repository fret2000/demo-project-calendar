<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


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
}
