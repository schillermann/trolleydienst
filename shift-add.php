<?php
if(!isset($_GET['id_shift_type'])) {
    header('location: info.php');
    return;
}

require 'includes/init_page.php';
$database_pdo = Tables\Database::get_connection();
$placeholder = array();

if(isset($_POST['save'])) {

    $date = include 'filters/post_date.php';

    $merge_date_and_time = include 'modules/merge_date_and_time.php';
    $shiftday_from = $merge_date_and_time($date, $_POST['time_from']);
    $shiftday_to = $merge_date_and_time($date, $_POST['time_to']);

    if ($_POST['shiftday_series_until'] != '') {
        $shiftdays_until = new \DateTime($_POST['shiftday_series_until']);
        $shiftdays_until->setTime(23,59);
    } else {
        $shiftdays_until = clone $shiftday_to;
    }

    $shiftday = new Models\ShiftDay(
        0,
        (int)$_POST['shift_type'],
        include 'filters/post_place.php',
        $shiftday_from,
        $shiftday_to,
        include 'filters/post_color_hex.php'
    );
    $shift_hour_number = (int)$_POST['shift_hour_number'];

    while ($shiftday_from < $shiftdays_until) {

        $add_shiftday_with_shifts = include 'services/add_shiftday_with_shifts.php';
        if($add_shiftday_with_shifts($database_pdo, $shiftday, $shift_hour_number))
            $placeholder['message']['success'][] = $shiftday_from->format('d.m.Y') . ' ' . $shiftday_from->format('H:i') . ' - ' . $shiftday_to->format('H:i');

        $shiftday_from->add(new \DateInterval('P7D'));
        $shiftday_to->add(new \DateInterval('P7D'));
    }
}

$placeholder['id_shift_type'] = (int)$_GET['id_shift_type'];
$placeholder['shift_types'] = Tables\ShiftTypes::select_all($database_pdo);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);