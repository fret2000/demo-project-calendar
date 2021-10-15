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
    ]
){
    $isReadyToDisplay = false;
    $eventBeginTimeToday = 0;
    $eventEndTimeToday = 0;

    $currentDate = 0;
    $currentTime = 0;
    $step = 0;

    $eventStartDate = 0;
    $eventFinishDate = 0;
    $eventStartTime = 0;
    $eventFinishTime = 0;

    $workDayStartTime = 0;
    $workDayFinishTime = 0;

    if($currentDate == $eventStartDate)
    {
        if($currentDate == $eventFinishDate)
        {
            $eventEndTimeToday = min($eventFinishTime, $workDayFinishTime);
        }
        else
        {
            $eventEndTimeToday = $workDayFinishTime;
        }
        $eventBeginTimeToday = $eventStartTime;
        $isReadyToDisplay = ($currentTime <= $eventStartTime && $eventStartTime <= $currentTime + $step);
    }
    elseif($currentDate == $eventFinishDate)
    {
        if($eventFinishTime > $workDayStartTime)
        {
            $eventEndTimeToday = $eventFinishTime;
            $eventBeginTimeToday = $workDayStartTime;

            $isReadyToDisplay = ($currentTime == $workDayStartTime);
        }
    }
    elseif($eventStartDate < $currentDate && $currentDate < $eventFinishDate){
        $eventEndTimeToday = $workDayFinishTime;
        $eventBeginTimeToday = $workDayStartTime;

        $isReadyToDisplay = ($currentTime == $workDayStartTime);
    }

    $durationEventTime = $eventEndTimeToday - $eventBeginTimeToday;
    if($isReadyToDisplay)
    {
        display();
    }
}
