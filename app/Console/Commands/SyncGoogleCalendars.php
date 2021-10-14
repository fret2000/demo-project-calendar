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
//            print "\nCalendar: \n";
//            print "id: ".$calendar->id."\n";
//            print "Name: ".$calendar->name."\n";
//            print "Type: ".$calendar->type."\n";
//            print "Platform: ".$calendar->platform."\n";
//            print "Plat_Cal_id: ".$calendar->platform_calendar_id."\n";
//            foreach($calendar as $key => $value)
//            {
//                print "$key : $value \n";
//            }


            if($calendar->platform != 'google')
            {
                continue;
            }

            /*
            В этом месте упадет как на страшную бабушку,
            если передать несуществующий platform_calendar_id
            */
            $events = $gCalendar->fetchEvents($calendar->platform_calendar_id);


            //$events = array();
            //$events = $gCalendar->fetchEvents('dvatishka@gmail.com');
            //$events = $gCalendar->fetchEvents('deagleeeee01@gmail.com');

            foreach($events as $event)
            {
                $event['calendar_id'] = $calendar->id;
                $event['is_accepted'] = 1;
                $event['is_blocking'] = 0;

                $event['date_start'] = $this->convertGTimeToDBTime($event['date_start']);
                $event['date_finish'] = $this->convertGTimeToDBTime($event['date_finish']);

//                print "\nEvent: \n";
//                foreach($event as $key => $value)
//                {
//                    print "$key : $value \n";
//                }
                Event::create($event);
            }
            break;
        }

        print "\n\nЩа *зданется, я снимаю!\n";

        return 0;
    }

    protected function convertGTimeToDBTime($oldTime)
    {
        $plusIndex = strpos($oldTime, '+');
        $cropTime = substr($oldTime, 0, $plusIndex);
        $newTime = str_replace('T', ' ', $cropTime);

        return $newTime;
    }
}
