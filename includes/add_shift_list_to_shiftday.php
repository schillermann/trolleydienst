<?php
return function (PDO $database, Models\ShiftDay $shiftday, int $shift_hour_number): bool {

    if ($shift_hour_number < 1)
        $shift_hour_number = 1;

    $shiftday_interval = new DateInterval('PT' . $shift_hour_number . 'H');
    $shiftday_range = new DatePeriod($shiftday->get_datetime_from(), $shiftday_interval ,$shiftday->get_datetime_to());
    $id_shift = 0;

    foreach($shiftday_range as $shiftday_begin){
        $id_shift++;
        $shiftday_end = clone $shiftday_begin;
        $shiftday_end->add($shiftday_interval);

        $shift = new Models\Shift($id_shift, $shiftday->get_id_shift_day(), $shiftday_begin, $shiftday_end);

        if(!Tables\Shifts::update($database, $shift) && !Tables\Shifts::insert($database, $shift))
            return false;
    }
    return true;
};