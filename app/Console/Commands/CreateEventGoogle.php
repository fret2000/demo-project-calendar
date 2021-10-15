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
    public function handle():int
    {
        $gCalendar = new GoogleCalendar();

        foreach(Calendar::all() as $calendar)
        {
            $gCalendarId = $calendar->platform_calendar_id;

            $internalEvents = Event::where('calendar_id', $calendar->id)->where('external_id', '0');



            $internalEvents->each(
                function ($item)
                use ($gCalendar, $gCalendarId)
            {
                $externalId =
                    $gCalendar->createEvent(
                    $gCalendarId,
                    $item->title,
                    [
                        'start'=>$this->convertDBTimeToGTime($item->date_start),
                        'finish'=>$this->convertDBTimeToGTime($item->date_finish)
                    ]
                );
                $item->external_id = $externalId;

                $item->save();
            });
        }
        return 0;
    }

    protected function convertDBTimeToGTime($oldTime): string
    {
        if(empty($oldTime))
        {
            // Это весьма простое-глупое решение, зато достаточно понятное
            $oldTime = '2000-01-01 00:00:00';
        }

        $newTime = str_replace(' ', 'T', $oldTime);

        //Чтобы событие на 10 часов отображалось в 10 часов (актульно для нашего часового пояса)
        $newTime .= '+04:00';

        return $newTime;
    }
}
