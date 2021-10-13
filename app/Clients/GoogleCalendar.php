<?php

namespace App\Clients;

use Google\Service\Calendar\Event;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class GoogleCalendar
{
    protected const APPNAME = 'Google Calendar API PHP Quickstart';
    protected const AUTHCONF = 'credentials.json';

    protected $client = null;

    public function __construct()
    {
        $this->client = null;
        $this->client = $this->getClient();
        //$service = new Google_Service_Calendar($this->client);
    }

    public function getClient()
    {
        if(!is_null($this->client))
        {
            return $this->client;
        }

        $client = new Google_Client();
        $client->setApplicationName(self::APPNAME);
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig(self::AUTHCONF);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if(file_exists($tokenPath))
        {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
//        if(!$client->isAccessTokenExpired())
//        {
//            die("Oops! GoogleCalendar: Access token is expired");
//            return;
//        }

        // Refresh the token if possible, else fetch a new one.
        if($client->getRefreshToken())
        {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        }else
        {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if(array_key_exists('error', $accessToken))
            {
                throw new Exception(join(', ', $accessToken));
            }
        }

        // Save the token to a file.
        if(!file_exists(dirname($tokenPath)))
        {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));

        return $client;
    }

    public static function simplificateEvent($eventList)
    {
        $simpleEventList = array();

        /** @var Event $event */
        foreach($eventList as $event)
        {
            $simpleEvent = array();

            $simpleEvent ['title'] = $event->getSummary();
            $simpleEvent ['date_start'] = $event->getStart()->getDateTime();
            $simpleEvent ['date_finish'] = $event->getEnd()->getDateTime();

            $simpleEventList [] = $simpleEvent;
        }

        return $simpleEventList;
    }

    public function fetchEvents($calendarId = 'primary', $from = '2000-01-01T00:00:00-00:00'):array
    {
        $optParams = array(
            //'maxResults' => 10,
            //'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c', (int)$from)
        );

        $service = new Google_Service_Calendar($this->getClient());
        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        $simpleEvents = static::simplificateEvent($events);
        return $simpleEvents;
    }

    public function createEvent($calendarId = 'primary',
                                $name = 'Event without name',
                                $dateTime = ["start" => '2015-05-28T09:00:00-07:00',
                                    "finish" => '2015-05-28T17:00:00-07:00'],
                                $options = []
    )
    {
        $defaultDescription = 'Event created from ImageSpark-Intranet';

        $event = new Google_Service_Calendar_Event(array(
                                                       'summary' => $name,
                                                       'description' => $defaultDescription,
                                                       'start' => array(
                                                           'dateTime' => $dateTime["start"],
                                                       ),
                                                       'end' => array(
                                                           'dateTime' => $dateTime["finish"]
                                                       )
                                                   ));

        $service = new Google_Service_Calendar($this->getClient());
        $event = $service->events->insert($calendarId, $event);
        //printf('Event created: %s\n', $event->htmlLink);
    }
}
