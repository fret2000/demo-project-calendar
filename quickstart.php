<?php
require __DIR__ . '/vendor/autoload.php';

if(php_sapi_name() != 'cli')
{
    throw new Exception('This application must be run on the command line.');
}

/**
* Returns an authorized API client.
* @return Google_Client the authorized client object
*/

function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP Quickstart');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig('credentials.json');
    //$client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    $tokenPath = 'token.json';
    if(file_exists($tokenPath))
    {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    if($client->isAccessTokenExpired())
    {
        if($client->getRefreshToken())
        {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        }
        else
        {
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            if(array_key_exists('error', $accessToken))
            {
                throw new Exception(join(', ', $accessToken));
            }
        }
        if(!file_exists(dirname($tokenPath)))
        {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

$client = getClient();
$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
    'maxResults' => 10,
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => date('c', '2020-06-03T10:00:00-07:00'),
    'showDeleted' => true
);
$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();

if(empty($events))
{
    print "No upcoming events found.\n";
}
else
{
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
$calendarService = new Google_Service_Calendar();
$calendars = $calendarService->calendars;

print "\n================================================\n";
print "Debug info: \n";

$calendarId = 'imagespark.intranet@gmail.com';
$events = $service->events->listEvents($calendarId, $optParams)->getItems();

if(empty($events))
{
    dd("Vam pi.\n");
}

foreach($events as $event)
{
    $start = empty($event->start->dateTime)
        ? $event->start->date
        : $event->start->dateTime;


    print "\nSummary: ".$event->getSummary();
    print "\nDescription: ".$event->getDescription();

    print "\nID: ".$event->getId();
    print "\nType: ".$event->getEventType();
    print "\nKind: ".$event->getKind();
    print "\nEtag: ".$event->getEtag();

    print "\nCreated: ".$event->getCreated();
    print "\nStart: ".$event->getStart()->getDateTime();
    print "\nEnd: ".$event->getEnd()->getDateTime();


    printf("\n%s (%s)\n", $event->getSummary(), $start);
}

print "\n";

$calendarList = $service->calendarList->listCalendarList();

while(true) {
    foreach ($calendarList->getItems() as $calendarListEntry) {
        echo $calendarListEntry->getSummary()."\n";
    }
    $pageToken = $calendarList->getNextPageToken();
    if ($pageToken) {
        $optParams = array('pageToken' => $pageToken);
        $calendarList = $service->calendarList->listCalendarList($optParams);
    } else {
        break;
    }
}

print "\n================================================\n";

$event = new Google_Service_Calendar_Event(array(
    'summary' => 'Goo15',
    'start' => array(
        'dateTime' => '2021-10-15T05:00:00-07:00',
    ),
    'end' => array(
        'dateTime' => '2021-10-15T15:00:00-07:00',
    )
));

$event = $service->events->insert('primary', $event);
printf("Event created: %s\n", $event->htmlLink);

//foreach ($events as $event)
//{
//    dd($event);
//}
