<?php

namespace App\Http\Controllers;

use App\Models\Event;
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

    public function indexWorker($idCalendar, $date = null)
    {

        if ($date == null) {
            $date = date("Y-m-d");
        }

        $currentDate = strtotime($date);

        return view('worker', collect([
            'idCalendar' => $idCalendar,
            'date' => $date,
            'currentDate' => $currentDate
        ]));

    }

    public function select() {
        $id = request()->get('calendar', 0);

        return redirect('/worker/' . $id . '/');
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
        return view('worker', [
            'Event' => Event::findOrFail($id)
        ]);
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
