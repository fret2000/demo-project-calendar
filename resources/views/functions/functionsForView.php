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
function in_line($ct, $hm, $step): bool
{
    //$hm = $h * 60 + $m;
    return ($hm <= $ct && $ct <= $hm + $step);
}
function getCell($cd, $ds, $df, $hs, $hf, $step)
{
    $cell = 0;
    if($cd['day'] == $ds['day'])
    {
        if(in_line($ds['hm'], $cd['hm'], $step))
        {
            $cell = $hf - $ds['hm'];
        }
    }elseif($cd['day'] == $df['day'])
    {
        if(in_line($hs, $hs, $step))
        {
            $cell = $df['hm'] - $hs;
        }
    }elseif($ds['day'] < $cd['day'] && $cd['day'] < $df['day'])
    {
        if(in_line($hs, $hs, $step))
        {
            $cell = $hf - $hs;
        }
    }
    return $cell;
}


