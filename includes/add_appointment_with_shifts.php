<?php
return function (\PDO $database, Models\Appointment $appointment, int $shift_hour_number): bool {

    $insert_appointment = include 'tables/insert_appointment.php';

    if(($id_appointment = $insert_appointment($database, $appointment)) === -1)
        return false;

    $appointment = new Models\Appointment(
        $id_appointment,
        $appointment->get_type(),
        $appointment->get_place(),
        $appointment->get_time_from(),
        $appointment->get_time_to(),
        $appointment->is_extra_shift()
    );

    $add_shifts = include 'includes/add_shifts.php';
    $add_shifts($database, $appointment, $shift_hour_number);

    return true;
};