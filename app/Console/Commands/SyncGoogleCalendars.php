<?php

namespace App\Console\Commands;

use App\Calendar;
use App\Clients\GoogleCalendar;
use Google_Client;
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
        $client = new GoogleCalendar();
        foreach (Calendar::all() as $calendar) {
            if ($calendar->type == 'google') {
                $events = $client->fetchEvents();

                foreach ($events as $event) {
                    Event::create(); // $event
                }


            }
        }
    }
}
