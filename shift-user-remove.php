<?php
session_start();
require 'includes/redirect_login.php';

$id_schedule = include 'includes/get_value_id_schedule.php';
$id_shift = include 'includes/get_value_id_shift.php';

if($id_schedule === 0 || $id_shift === 0)
    header('location: shift.php');

$database_pdo = include 'includes/database_pdo.php';

$stmt_delete_user_from_shift = $database_pdo->prepare(
    'DELETE FROM schichten_teilnehmer 
    WHERE terminnr = :id_schedule
    AND Schichtnr = :id_shift
    AND teilnehmernr = :id_user'
);

$stmt_delete_user_from_shift->execute(
    array(
        ':id_schedule' => $id_schedule,
        ':id_shift' => $id_shift,
        ':id_user' => $_SESSION['id_user']
    )
);

$anchor = '#id_schedule_' . $id_schedule . '_id_shift_' . $id_shift;

if($stmt_delete_user_from_shift->rowCount() == 1)
    header('location: shift.php' . $anchor);


$stmt_select_shift = $database_pdo->prepare(
    'SELECT von AS datetime_from, bis AS datetime_to
    FROM schichten
    WHERE terminnr = :id_schedule
    AND Schichtnr = :id_shift'
);

$stmt_select_shift->execute(
    array(
        ':id_schedule' => $id_schedule,
        ':id_shift' => $id_shift
    )
);

$shift_datetime = $stmt_select_shift->fetch();
$template_placeolder['shift_datetime_from'] = new \DateTime($shift_datetime['datetime_from']);
$template_placeolder['shift_datetime_to'] = new \DateTime($shift_datetime['datetime_to']);

$render_page = include 'includes/page_render.php';
echo $render_page($template_placeolder);