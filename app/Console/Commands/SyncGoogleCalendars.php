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
            $googleEvents = $gCalendar->fetchEvents($calendar->platform_calendar_id);
            //$googleEvents = $gCalendar->fetchEvents('deagleeeee01@gmail.com');

            foreach($googleEvents as $googleEvent)
            {
                $googleEvent['calendar_id'] = $calendar->id;
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
            }
        }

        //print "\n\nЩа *зданется, я снимаю!\n";
        return 0;
    }

    protected function convertGTimeToDBTime($oldTime)
    {
        if(empty($oldTime))
        {
            $oldTime = '2000-01-01T00:00:00+00:00';
        }
        $plusIndex = strpos($oldTime, '+');
        $cropTime = substr($oldTime, 0, $plusIndex);
        $newTime = str_replace('T', ' ', $cropTime);

        return $newTime;
    }
}
