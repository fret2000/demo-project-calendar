<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
}
