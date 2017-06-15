<?php
require 'includes/init_page.php';

$placeholder = array();
$database_pdo = include 'includes/database_pdo.php';

if(isset($_POST['delete_user'])) {
    $shift_user_remove = include "services/remove_user_from_shift.php";

    if($shift_user_remove($database_pdo, $_SESSION['id_user'], (int)$_POST['id_shift_day'], (int)$_POST['id_shift']))
        $placeholder['message']['success'] = 'Deine Bewerbung wurde zurück gezogen.';
    else
        $placeholder['message']['error'] = 'Deine Bewerbung konnte nicht zurück gezogen werden!';
}
elseif (isset($_POST['promote_user'])) {
    $promote_user_for_shift = include 'services/promote_user_for_shift.php';
    if($promote_user_for_shift($database_pdo, $_SESSION['id_user'], (int)$_POST['id_shift_day'], (int)$_POST['id_shift']))
        $placeholder['message']['success'] = 'Deine Bewerbung wurde angenommen.';
    else
        $placeholder['message']['error'] = 'Deine Bewerbung konnte nicht angenommen werden!';
}


$stmt_settings_schedule_max_days = $database_pdo->prepare(
    'SELECT FilterTerminTage FROM settings'
);

$stmt_settings_schedule_max_days->execute();
$mTageFilter = (int)$stmt_settings_schedule_max_days->fetchColumn();

$AllowSchichtArt = array(-1);

if ($_SESSION['literature_table'] != Enum\Status::INACTIVE)
    $AllowSchichtArt[] = 0;
if ($_SESSION['literature_cart'] != Enum\Status::INACTIVE)
    $AllowSchichtArt[] = 1;

$select_shifts_days_list = include 'tables/select_shifts_days_list.php';
$shiftday_list = $select_shifts_days_list($database_pdo, $mTageFilter, $AllowSchichtArt);


$placeholder['shiftday_list'] = array();

foreach ($shiftday_list as $shiftday) {

    $shiftday_shift_list = new Models\ShiftDayShiftList($shiftday);

    $select_shift_list = include 'tables/select_shifts_list.php';
    $shift_list = $select_shift_list($database_pdo, $shiftday->get_id_shift_day());

    foreach ($shift_list as $shift) {

        $shift_user_list = new Models\ShiftUserList($shift);

        $stmt_users_from_shift = $database_pdo->prepare(
            'SELECT SchTeil.teilnehmernr AS id_user, SchTeil.status AS status,
            SchTeil.isschichtleiter AS shift_supervisor, muser.vorname AS firstname,
            muser.nachname AS surname, muser.Handy AS mobile
            FROM schichten_teilnehmer SchTeil
            LEFT OUTER JOIN teilnehmer muser
            ON SchTeil.teilnehmernr = muser.teilnehmernr
            WHERE SchTeil.terminnr = :id_shift_day
            AND SchTeil.schichtnr = :id_shift
            ORDER BY SchTeil.isschichtleiter DESC'
        );

        $stmt_users_from_shift->execute(
            array(
                ':id_shift_day' => $shift->get_id_shift_day(),
                ':id_shift' => $shift->get_id_shift()
            )
        );

        while($user_from_shift = $stmt_users_from_shift->fetchObject('Models\ShiftUser'))
            $shift_user_list->add_user_to_shift($user_from_shift);

        $shiftday_shift_list->add_shift_user_list($shift_user_list);
    }

    $placeholder['shiftday_list'][] = $shiftday_shift_list;
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);