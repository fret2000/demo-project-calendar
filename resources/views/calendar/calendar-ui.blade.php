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
                          "day" => $columnDate,
                          'HourAndMinutes' => ($hour['hour'] * 60) + $hour['minute']
                        ];
                    $DayStart =
                        [
                            "day" => $parseDateStart,
                            'HourAndMinutes' => ($parseTimeStart[0] * 60) + $parseTimeStart[1]
                        ];
                    $DayFinish =
                        [
                            "day" => $parseDateFinish,
                            'HourAndMinutes' => ($parseTimeFinish[0] * 60) + $parseTimeFinish[1]
                        ];
                    $HourStart = $hourStart*60;
                    $HourFinish = $hourFinish*60;
                ?>
                @if (($hour['hour'] == $parseTimeStart[0] || $hour['hour'] == $hourStart) && $hour['minute'] == $parseTimeStart[1])
                    <?php
                        if($dayStart <= $columnDate && $columnDate <= $dayFinish)
                        {
                            $topPosition = round(0 / 15 * $cellHeight);
                            if ($parseDateStart == $parseDateFinish && $event['is_accepted'] == 1)
                            {
                                $diffMinutes = ($dateFinish - $dateStart) / 60;
                                $cell = $cellHeight * ($diffMinutes / 15);
                    ?>
                            <div class="calendar__event"
                                style="top:{{ $topPosition }}px; left:5px; height: {{$cell+$cellHeight}}px; width: {{$cellWidth}}px">
                                <div>
                                    <?php echo $event['title']?><br><?php echo $parseDateTimeStart[1] ?>
                                </div>
                            </div>
                        <?php
                            }
                            elseif ($parseDateStart < $parseDateFinish && $event['is_accepted'] == 1)
                            {
                                $diffMinutes = ($dateFinish - $dateStart) / 60;
                                $cell = $cellHeight * (getCell($curDay, $DayStart, $DayFinish, $hourStart, $HourFinish, $minuteStep) / 15);
                        ?>
                            <div class="calendar__event"
                                style="top:{{ $topPosition }}px; left:5px; height: {{$cell+$cellHeight}}px; width: {{$cellWidth}}px">
                                <div>
                                    <?php echo $event['title']?><br><?php echo $parseDateTimeStart[1];?>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        ?>
                @endif
            @endforeach
        </td>
        <? } ?>
    </tr>
    <? } ?>
</table>
