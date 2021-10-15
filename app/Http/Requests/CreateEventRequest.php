<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'currentDate' => 'required',
            'retryEvent' => 'required',
           // 'room' => 'required',
            'time_start' => 'required',
            'date_start' => 'required',
            'time_finish' => 'required',
            'date_finish' => 'required',
            'title' => 'required',
            'idCalendar' => 'required'
        ];
    }

    public function afterValidation()
    {
        $request = $this->validated();


        if (isset($request['room']) && $request['room'] == 'event') {
            $request['is_blocking'] = 0;
        } else {
            $request['is_blocking'] = 1;
        }
        $request['is_accepted'] = 0;
        $request['calendar_id'] = $this['idCalendar'];
        $request['date_start'] = $request['date_start'] . " " . $request['time_start'];
        $request['date_finish'] = $request['date_finish'] . " " . $request['time_finish'];
        $request = Arr::only($request, ['title', 'date_start', 'date_finish', 'is_accepted', 'is_blocking', 'calendar_id']);

        return $request;
    }
}
