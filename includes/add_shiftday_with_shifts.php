<?php
return function (\PDO $database, Models\ShiftDay $shiftday, int $shift_hour_number): bool {

    $insert_shifts_days = include 'tables/insert_shifts_days.php';

    if(($id_shift_day = $insert_shifts_days($database, $shiftday)) === -1)
        return false;

    $shiftday_with_new_id = new Models\ShiftDay(
        $id_shift_day,
        $shiftday->get_type(),
        $shiftday->get_place(),
        $shiftday->get_time_from(),
        $shiftday->get_time_to(),
        $shiftday->is_extra_shift()
    );

    $add_shifts = include 'includes/add_shifts.php';
    $add_shifts($database, $shiftday_with_new_id, $shift_hour_number);

    return true;
};