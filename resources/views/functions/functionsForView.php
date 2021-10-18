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
        $isReadyToDisplay = ($current['time'] <= $event['start']['time'] && $event['start']['time'] < $current['time'] + $step);
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

    return [
        "duration" =>$durationEventTime,
        "display" => $isReadyToDisplay,
        'offset' => $eventBeginTimeToday - $current['time']
    ];
}
