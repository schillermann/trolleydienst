<?php
return function (PDO $database, Models\ShiftDay $shiftday, int $shift_hour_number): bool {

    if ($shift_hour_number < 1)
        $shift_hour_number = 1;

    $shiftday_interval = new DateInterval('PT' . $shift_hour_number . 'H');
    $shiftday_range = new DatePeriod($shiftday->get_time_from(), $shiftday_interval ,$shiftday->get_time_to());
    $id_shift = 0;

    foreach($shiftday_range as $shiftday_begin){
        $id_shift++;
        $shiftday_end = clone $shiftday_begin;
        $shiftday_end->add($shiftday_interval);

        $shift = new Models\Shift($id_shift, $shiftday_begin, $shiftday_end, $shiftday->get_id_shift_day());

        $update_shift = include 'tables/update_shifts.php';
        $insert_shift = include 'tables/insert_shifts.php';

        if(!$update_shift($database, $shift) && !$insert_shift($database, $shift))
            return false;
    }
    return true;
};