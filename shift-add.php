<?php
if(!isset($_GET['id_shift_type'])) {
    header('location: info.php');
    return;
}

$placeholder = require 'includes/init_page.php';

if(isset($_POST['save'])) {

    $date = include 'filters/post_date.php';

    $merge_date_and_time = include 'modules/merge_date_and_time.php';
    $shiftday_from = $merge_date_and_time($date, $_POST['time_from']);

    if ($_POST['shiftday_series_until'] != '') {
        $shiftdays_until = new \DateTime($_POST['shiftday_series_until']);
        $shiftdays_until->setTime(23,59);
    } else {
        $shiftdays_until = clone $shiftday_from;
    }

    $shiftday = new Models\ShiftDay(
        0,
        (int)$_GET['id_shift_type'],
        include 'filters/post_place.php',
        $shiftday_from,
        (int)$_POST['number'],
        (float)$_POST['hours_per_shift'],
        include 'filters/post_color_hex.php'
    );

    while ($shiftday_from <= $shiftdays_until) {

        if(Tables\ShiftsDays::insert($database_pdo, $shiftday))
            $placeholder['message']['success'][] = $shiftday_from->format('d.m.Y') . ' ' . $shiftday_from->format('H:i');
        else
            $placeholder['message']['error'][] = $shiftday_from->format('d.m.Y') . ' ' . $shiftday_from->format('H:i');

        $shiftday_from->add(new \DateInterval('P7D'));
    }
}

$placeholder['id_shift_type'] = (int)$_GET['id_shift_type'];

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);