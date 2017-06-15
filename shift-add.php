<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';
$placeholder = array();

if(isset($_POST['save'])) {

    if ($_POST['appointment_series_until'] != '')
        $appointment_series_until = $filter_date_and_time($_POST['appointment_series_until']);

    $filter_date_and_time = include 'modules/filter_date_and_time.php';
    $appointment_from = $filter_date_and_time($_POST['date'], $_POST['time_from']);
    $appointment_to = $filter_date_and_time($_POST['date'], $_POST['time_to']);
    $extra_shift = isset($_POST['is_extra_shift']);

    $appointment = new Models\Appointment(
        0,
        (int)$_POST['date_type'],
        $_POST['place'],
        $appointment_from,
        $appointment_to,
        $extra_shift
    );

    // TODO: Foreach Schleife mit einem Interval wie bei $add_appointment_with_shifts mit der Termin Serie

    $add_appointment_with_shifts = include 'includes/add_appointment_with_shifts.php';
    $add_appointment_with_shifts($database_pdo, $appointment, (int)$_POST['shift_hour_number']);
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);