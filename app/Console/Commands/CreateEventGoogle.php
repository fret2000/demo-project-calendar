<?php

namespace App\Console\Commands;

use App\Clients\GoogleCalendar;
use App\Models\Calendar;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CreateEventGoogle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $gCalendar = new GoogleCalendar();

        foreach(Calendar::all() as $calendar)
        {
            $gCalendarId = $calendar->platform_calendar_id;
            $googleEvents = $gCalendar->fetchEvents($gCalendarId);
//            print_r($calendar);
            $a = Event::where('calendar_id', $calendar->id)->where('external_id', 0);



            $a->each(function ($item) use ($gCalendar, $gCalendarId) {

                $externalId =
                    $gCalendar->createEvent(
                    $gCalendarId,
                    $item['title'],
                    [
                        'start'=>$this->convertDBTimeToGTime($item->date_start),
                        'finish'=>$this->convertDBTimeToGTime($item->date_finish)
                    ]
                );
                $item->external_id = $externalId;

                $item->save();
            });

            //dd("Ты охуел?");

//            $a->each(function ($item){
//               dd("Петух и пидорас, зато работает ".$item->external_id);
//            });




            //dd($googleEvents);
              //  $gCalendar->createEvent();


            //$dataEvent = Event::where($calendar['calendar_id']  = 0);

        //        print_r($dataEvent);

        }






    //    $gCalendar->createEvent();

    }

    protected function convertDBTimeToGTime($oldTime): string
    {
        if(empty($oldTime))
        {
            // Это весьма простое-глупое решение, зато достаточно понятное
            $oldTime = '2000-01-01 00:00:00';
        }

        $newTime = str_replace(' ', 'T', $oldTime);
        $newTime .= '+04:00';

        return $newTime;
    }
}
