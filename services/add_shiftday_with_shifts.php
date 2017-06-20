<?php
return function (\PDO $database, Models\ShiftDay $shiftday, int $shift_hour_number): bool {

    if(!($id_shift_day = Tables\ShiftsDays::insert($database, $shiftday)))
        return false;

    $shiftday_with_new_id = new Models\ShiftDay(
        $id_shift_day,
        $shiftday->get_type(),
        $shiftday->get_place(),
        $shiftday->get_datetime_from(),
        $shiftday->get_datetime_to(),
        $shiftday->is_extra_shift()
    );

    $add_shift_list_to_shiftday = include 'includes/add_shift_list_to_shiftday.php';
    return $add_shift_list_to_shiftday($database, $shiftday_with_new_id, $shift_hour_number);
};