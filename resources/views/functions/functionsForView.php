<?php
function getTimetable($hourStart = 10, $hourFinish = 19, $minuteStep = 15)
{
    $timetable = array();

    $minute = -$minuteStep;
    $hour = $hourStart;

    while ($hour < $hourFinish) {
        $minute += (int)$minuteStep;

        if ($minute >= 60) {
            $minute = 0;
            $hour++;
        }

        if ($minute == 0) {
            $minute = '00';
        }

        $timetable [] = ['hour' => $hour,
            'minute' => $minute
        ];
    }

    return $timetable;
}
function in_line($CurrentTime, $HourAndMinutes, $step): bool
{
    return ($HourAndMinutes <= $CurrentTime && $CurrentTime <= $HourAndMinutes + $step);
}
function getCell($CurrentDay, $DayStart, $DayFinish, $hourStart, $HourFinish, $step)
{
    $HourStart = $hourStart*60;
    $cell = 0;
    if($CurrentDay['day'] == $DayStart['day'])
    {
        if(in_line($DayStart['HourAndMinutes'], $CurrentDay['HourAndMinutes'], $step))
        {
            $cell = $HourFinish - $DayStart['HourAndMinutes'];
        }
    }elseif($CurrentDay['day'] == $DayFinish['day'])
    {
        //////////////////////////////////////////////////////////////////////////
        if(in_line($HourFinish, $HourFinish, $step))
        ///////////////////////////////////////////////////////////////////////////////
        {
            $cell = $DayFinish['HourAndMinutes'] - $HourStart;
        }
    }elseif($DayStart['day'] < $CurrentDay['day'] && $CurrentDay['day'] < $DayFinish['day'])
    {
        $a = $CurrentDay['HourAndMinutes'] - $HourStart;
        $CurrentDay['HourAndMinutes'] = $CurrentDay['HourAndMinutes'] - $a;
        if(in_line($CurrentDay['HourAndMinutes'], $HourStart, $step))
        {
            $cell = $HourFinish - $CurrentDay['HourAndMinutes'];
        }
//        if(in_line($HourStart, $HourStart, $step))
//        {
//            $cell = $HourFinish - $HourStart;
//        }
    }
    return $cell;
}

function getDurationEventTime(
    $current =
    [
        'date'=>"d-m-Y",
        'time'=>'unix'
    ],
    $event =
    [
        'start' =>
            [
                'date' => "d-m-Y",
                'time' => 'unix'
            ],
        'finish' =>
            [
                'date' => "d-m-Y",
                'time' => 'unix'
            ]
    ],
    $workDayTime =
    [
        'start' => 'unix',
        'finish' => 'unix'
    ],
    $step = 15
){
    $isReadyToDisplay = false;
    $eventBeginTimeToday = 0;
    $eventEndTimeToday = 0;

    if($current['date'] == $event['start']['date'])
    {
        if($current['date'] == $event['finish']['date'])
        {
            $eventEndTimeToday = min($event['finish']['time'], $workDayTime['finish']);
        }
        else
        {
            $eventEndTimeToday = $workDayTime['finish'];
        }
        $eventBeginTimeToday = $event['start']['time'];
        $isReadyToDisplay = ($current['time'] <= $event['start']['time'] && $event['start']['time'] <= $current['time'] + $step);
    }
    elseif($current['date'] == $event['finish']['date'])
    {
        if($event['finish']['time'] > $workDayTime['start'])
        {
            $eventEndTimeToday = $event['finish']['time'];
            $eventBeginTimeToday = $workDayTime['start'];

            $isReadyToDisplay = ($current['time'] == $workDayTime['start']);
        }
    }
    elseif($event['start']['date'] < $current['date'] && $current['date'] < $event['finish']['date']){
        $eventEndTimeToday = $workDayTime['finish'];
        $eventBeginTimeToday = $workDayTime['start'];

        $isReadyToDisplay = ($current['time'] == $workDayTime['start']);
    }

    $durationEventTime = $eventEndTimeToday - $eventBeginTimeToday;
    if($isReadyToDisplay)
    {
        display();
    }
}
