<?php
return function(string $datetime): string {
    $datetime_convert = new \DateTime($datetime);
    $weekday_number = (int)$datetime_convert->format('w');
    $day_name_list = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch','Donnerstag','Freitag', 'Samstag');
    return $day_name_list[$weekday_number];
};