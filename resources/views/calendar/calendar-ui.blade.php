<?php

$cellHeight = 50;

?>
<style>
    .calendar__cell {
        position: relative;
    }

    .calendar__cell-h {
        height:{{ $cellHeight }}px;
    }

    .calendar__event {
        position: absolute;
        border-radius: 3px;
        background-color: #ccc;
    }
    .calendar__event>div {
        padding:6px; 
    }
</style>

<table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col"></th>
                    @for ($i = 0; $i<=6; $i++)
                        <th scope="col">{{ date("d.m.Y", $currentDate + $i*60*60*24) }}</th>
                    @endfor
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Событие</th>
                    <td><a href=""></a></td>
                    <td><a href=""></a></td>
                    <td><a href=""></a></td>
                    <td><a href=""></a></td>
                    <td><a href=""></a></td>
                    <td><a href=""></a></td>
                    <td><a href=""></a></td>
                </tr>
                <?php

                function getTimetable($hourStart = 8, $hourFinish = 17, $minuteStep = 30)
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

                foreach (getTimetable(10, 19, 15) as $hour){
                ?>
                <tr>
                    <th class="calendar__cell-h" scope="row"><?=$hour['hour'] . ":" . $hour['minute']?></th>
                    <?php
                    for ($td = 0; $td < 7; $td++){
                    ?>

                    <td class="calendar__cell">
                        <a href=""></a>
                        
                        @if ($hour['hour'] == '10' && $hour['minute'] == 0) 
                        <?php
                        $topPosition = round(3/15*$cellHeight);
                        ?>
                            <div class="calendar__event" style="top:{{ $topPosition }}px;left:5px; height: 200px;">
                                <div>
                                    Событие
                                </div>
                            </div>
                        @endif
                    </td>
                    <? } ?>
                </tr>
                <?php  } ?>
                </tbody>
            </table>