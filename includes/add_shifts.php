<?php
return function (PDO $database, Models\Appointment $appointment, int $shift_hour_number): bool {

    if ($shift_hour_number < 1)
        $shift_hour_number = 1;

    $appointment_interval = new DateInterval('PT' . $shift_hour_number . 'H');
    $appointment_range = new DatePeriod($appointment->get_time_from(), $appointment_interval ,$appointment->get_time_to());
    $id_shift = 0;

    foreach($appointment_range as $appointment_begin){
        $id_shift++;
        $appointment_end = clone $appointment_begin;
        $appointment_end->add($appointment_interval);

        $shift = new Models\Shift($id_shift, $appointment_begin, $appointment_end, $appointment->get_id());

        $update_shift = include 'tables/update_shift.php';
        $insert_shift = include 'tables/insert_shift.php';

        if(!$update_shift($database, $shift) && !$insert_shift($database, $shift))
            return false;
    }
    return true;
};