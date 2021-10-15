<?php

namespace App\Console\Commands;

use App\Clients\GoogleCalendar;
use App\Models\Calendar;
use Illuminate\Console\Command;

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
        foreach(Calendar::all() as $calendar)
        {
            if ($calendar->platform_calendar_id);
        }
        $gCalendar = new GoogleCalendar();
        $googleEvents = $gCalendar->fetchEvents($calendar->platform_calendar_id);






        $gCalendar->createEvent();

    }
}
