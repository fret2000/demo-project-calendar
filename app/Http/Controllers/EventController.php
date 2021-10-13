<?php

namespace App\Http\Controllers;

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

    public function indexWorker($idCalendar = 1, $date = null)
    {
        $workers = User::findOrFail($idCalendar)->all();
        if ($date == null) {
            $date = date("Y-m-d");
        }

        $currentDate = strtotime($date);

        return view('worker', collect([
            'workers' => $workers,
            'idCalendar' => $idCalendar,
            'date' => $date,
            'currentDate' => $currentDate
        ]));

    }

    public function select() {
        $idCalendar = request()->get('calendar', 0);
//        '/worker/' . $id . '/'
        $arrayEventsOrWorker = $this->show($idCalendar);

        return redirect()->route('worker_id',[$idCalendar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request->all());
        $request = Arr::only($request->all(), ['date_start', 'date_finish', 'title']);

        Event::create($request);
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
//        return view('worker', [
//            'Event' => Event::findOrFail($id)->all()
//        ]);
        //$event = Event::where('id',$id)->first();
        //$event->show();
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
