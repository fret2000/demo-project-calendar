<?php

namespace App\Clients;

class GoogleCalendar {


    public function __construct()
    {
        $client = getClient();
        $service = new Google_Service_Calendar($client);

    }

    public function fetchEvents($calendarId = 'primary', $from = null) {
        
    }

    public function createEvent($calendarId = 'primary', $name, $options = []) {

    }
}