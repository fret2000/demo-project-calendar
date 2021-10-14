<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateEventRequest;
use App\Models\Calendar;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($idCalendar, $date = null)
    {
        if ($date == null) {
            $date = date("Y-m-d");
        }

        $currentDate = strtotime($date);

        return view('calendar', collect([
            'idCalendar' => $idCalendar,
            'date' => $date,
            'currentDate' => $currentDate
        ]));

    }

    public function indexWorker($id, $date = null)
    {
        if ($id)
        {
            $worker = User::with('calendars.events')->find($id);
                foreach($worker->calendars as $calendar)
                {
                    dump($calendar->events);
                }
        }

        $workers = User::all();
        if ($date == null) {
            $date = date("Y-m-d");
        }

        $currentDate = strtotime($date);
        return view('worker', collect([
            'workers' => $workers,
            'idCalendar' => $id,
            'date' => $date,
            'currentDate' => $currentDate
        ]));

    }


    public function select() {
        $idCalendar = request()->get('calendar', 0);
        $arrayEventsOrWorker = $this->show($idCalendar);

        return redirect()->route('worker_id',[$idCalendar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateEventRequest $request)
    {

        $request = $request->afterValidation();
        Event::create($request);
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $calendar = Calendar::findOrFail($id)->all();
        $event = Event::findOrFail($id)->all();
        $worker = User::findOrFail($id)->all();
        $CalendarEventWorker = array (
            'calendar' => $calendar,
            'event' => $event,
            'worker' => $worker
        );
        return $CalendarEventWorker;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = Arr::only($request->all(), ['date_start', 'date_finish', 'title']);
        $event = Event::where('id', $id)->first();
        $event->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::where('id', $id)->first();
        $event->delete($id);
    }
}
