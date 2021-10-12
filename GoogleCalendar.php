<?php

class GoogleCalendar
{
    protected const APPNAME = 'Google Calendar API PHP Quickstart';
    protected const AUTHCONF = 'credentials.json';

    protected $client = null;

    public function __construct()
    {
        $this->client = $this->getClient();
    }

    public function getClient()
    {
        if($this->client != null)
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
        if(!$client->isAccessTokenExpired()) {
            return;
        }

        // Refresh the token if possible, else fetch a new one.
        if($client->getRefreshToken())
        {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        }
        else
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

    public function getEventList($optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c')
    ))
    {
        $service = new Google_Service_Calendar($this->client);
        $calendarId = 'primary';

        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        return $events;
    }

    public static function printEvents($events)
    {
        if(is_array($events))
        {
            print "Events isn't array.\n";
            return;
        }

        if(empty($events))
        {
            print "No upcoming events found.\n";
            return;
        }

        print "Upcoming events:\n";
        foreach($events as $event)
        {
            $start = $event->start->dateTime;
            if(empty($start))
            {
                $start = $event->start->date;
            }
            printf("%s (%s)\n", $event->getSummary(), $start);
        }
    }
}
