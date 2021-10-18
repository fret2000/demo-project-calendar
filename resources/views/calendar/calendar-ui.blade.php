<?php

$cellHeight = 50;
$cellWidth = 110;

?>
@include('functions.functionsForView')
<style>
    .calendar__cell {
        position: relative;
    }

    .calendar__cell-h {
        height: {{ $cellHeight }}px;

    }

    .calendar__event {
        position: absolute;
        border-radius: 10px;
        background-color: #ccc;
    }

    .calendar__event > div {
        padding: 6px;
    }
</style>

<table class="table table-bordered table-striped">
    <tr>
        <th scope="col"></th>
        @for ($i = 0; $i<=6; $i++)
            <th scope="col">{{ date("d.m.Y", $currentDate + $i*60*60*24) }}</th>
        @endfor
    </tr>
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
    $hourStart = 8;
    $hourFinish = 19;
    $minuteStep = 15;
    foreach (getTimetable($hourStart, $hourFinish, $minuteStep) as $hour){
    ?>
    <tr>
        <th class="calendar__cell-h" scope="row"><?=$hour['hour'] . ":" . $hour['minute']?></th>
        <?php
        for ($td = 0; $td < 7; $td++){
            $columnDate = $currentDate + $td*60*60*24;
        ?>
        <td class="calendar__cell">
            @foreach($events as $event)
                <?php
                    $parseDateTimeStart = explode(' ', $event['date_start']);
                    $parseDateStart = $parseDateTimeStart[0];
                    $parseTimeStart = explode(':', $parseDateTimeStart[1]);
                    unset($parseTimeStart[2]);

                    $parseDateTimeFinish = explode(' ', $event['date_finish']);
                    $parseDateFinish = $parseDateTimeFinish[0];
                    $parseTimeFinish = explode(':', $parseDateTimeFinish[1]);
                    unset($parseTimeFinish[2]);

                    $dateStart = strtotime($event['date_start']);
                    $dateFinish = strtotime($event['date_finish']);
                    $columnDate1 = date("d.m.Y", $columnDate);

                    $dayStart = strtotime($parseDateTimeStart[0]);
                    $dayFinish = strtotime($parseDateTimeFinish[0]);

                    $parseDateStart = strtotime($parseDateStart);
                    $parseDateFinish = strtotime($parseDateFinish);

                    $curDay =
                        [
                          "date" => $columnDate,
                          'time' => ($hour['hour'] * 60) + $hour['minute']
                        ];
                    $DayStart =
                        [
                            "date" => $parseDateStart,
                            'time' => ($parseTimeStart[0] * 60) + $parseTimeStart[1]
                        ];
                    $DayFinish =
                        [
                            "date" => $parseDateFinish,
                            'time' => ($parseTimeFinish[0] * 60) + $parseTimeFinish[1]
                        ];
                    $Event = array(
                        'start' => $DayStart,
                        'finish' => $DayFinish
                    );

                    $HourStart = $hourStart*60;
                    $HourFinish = $hourFinish*60;
                    $workDay = array(
                        'start' => $HourStart,
                        'finish' => $HourFinish
                    );

                    $result = getDurationEventTime($curDay, $Event, $workDay, $minuteStep);

                    if($result['display'])
                        {
                            $topPosition = round($result['offset'] / 15 * $cellHeight);
                            $cell = $cellHeight * ($result['duration'] / $minuteStep);
                    ?>

                    <div class="calendar__event"
                         style="top:{{ $topPosition }}px; left:5px; height: {{$cell+$cellHeight}}px; width: {{$cellWidth}}px">
                        <div>
                            <?php echo $event['title']?><br><?php echo $parseDateTimeStart[1] ?>

                        </div>
                    </div>

                    <?php
                        }
                    ?>
                @endforeach
        </td>
        <? } ?>
    </tr>
    <? } ?>
</table>
