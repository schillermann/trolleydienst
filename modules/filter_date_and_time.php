<?php
return function (string $date, string $time = null) : \DateTime {

    if($date_format_german = DateTime::createFromFormat('d.m.Y', $date))
        $date_time = $date_format_german;
    elseif ($date_format_america = DateTime::createFromFormat('Y-m-d', $date))
        $date_time = $date_format_america;
    else
        $date_time = new \DateTime($date);

    if($time) {
        $hours_minutes = explode(':', $time);
        $date_time->setTime((int)$hours_minutes[0], (int)$hours_minutes[1]);
    }
    return $date_time;
};