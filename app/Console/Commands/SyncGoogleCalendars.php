<?php

namespace App\Console\Commands;

use App\Clients\GoogleCalendar;
use App\Models\Calendar;
use App\Models\Event;
use Illuminate\Console\Command;

class SyncGoogleCalendars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:google';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизирует все календари с Гуглом';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // From google to local db
        $gCalendar = new GoogleCalendar();

        foreach(Calendar::all() as $calendar)
        {
            if($calendar->platform != 'google')
            {
                continue;
            }

            /*
            В этом месте упадет как на страшную бабушку,
            если передать несуществующий platform_calendar_id
            */
            //ETO TYT DIMA
            //$simpleEvents = static::simplificateEvent($events);
            $googleEvents = $gCalendar->fetchEvents($calendar->platform_calendar_id);
            //$googleEvents = $gCalendar->fetchEvents('imagespark.intranet@gmail.com');

            $this->syncEvents($googleEvents, $calendar->id);
        }
        return 0;
    }

    protected function syncEvents($googleEvents, $calendarID)
    {
        foreach($googleEvents as $googleEvent)
        {
            $googleEvent['calendar_id'] = $calendarID;
            $googleEvent['is_accepted'] = 1;
            $googleEvent['is_blocking'] = 0;

            $googleEvent['date_start'] = $this->convertGTimeToDBTime($googleEvent['date_start']);
            $googleEvent['date_finish'] = $this->convertGTimeToDBTime($googleEvent['date_finish']);

            if(empty($googleEvent['title']))
            {
                $googleEvent['title'] = "auto: Title";
            }

            $event = Event::firstOrCreate(
                ['external_id' => $googleEvent['external_id']],
                $googleEvent
            );

            if(!$event->wasRecentlyCreated && !$this->isEqual($event, $googleEvent))
            {
                $this->syncEventsAndSave($event, $googleEvent);
            }
        }
    }

    protected function syncEventsAndSave($event, $gevent)
    {
        foreach($gevent as $key => $value)
        {
            $event[$key] = $value;
        }

        $event->save();
    }

    protected function isEqual($event, $gevent):bool
    {
        $result = true;

        foreach($gevent as $key => $value)
        {
            if($event[$key] != $value)
            {
                $result = false;
                break;
            }
        }

        return $result;
    }

    protected function convertGTimeToDBTime($oldTime)
    {
        if(empty($oldTime))
        {
            // Это весьма простое-глупое решение, зато достаточно понятное
            $oldTime = '2000-01-01T00:00:00+00:00';
        }
        $plusIndex = strpos($oldTime, '+');
        $cropTime = substr($oldTime, 0, $plusIndex);
        $newTime = str_replace('T', ' ', $cropTime);

        return $newTime;
    }
}
