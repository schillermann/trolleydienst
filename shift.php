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
    if($promote_user_for_shift($database_pdo, (int)$_POST['id_user'], (int)$_POST['id_shift_day'], (int)$_POST['id_shift']))
        $placeholder['message']['success'] = 'Deine Bewerbung wurde angenommen.';
    else
        $placeholder['message']['error'] = 'Deine Bewerbung konnte nicht angenommen werden!';
}

$user_list = Tables\Users::select_all_without_user($database_pdo, $_SESSION['id_user']);
$get_user_promote_list = include 'helpers/get_user_promote_list.php';
$placeholder['user_promote_list'] = $get_user_promote_list($user_list);

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

$placeholder['shiftday_list'] = Tables\ShiftsDays::select_all($database_pdo, $mTageFilter, $AllowSchichtArt);

foreach ($placeholder['shiftday_list'] as $shift_day) {

    $id_shift_day = (int)$shift_day['id_shift_day'];
    $placeholder['shift_list'][$id_shift_day] = $shift_list = Tables\Shifts::select_all($database_pdo, $id_shift_day);

    foreach ($shift_list as $shift) {
        $id_shift = (int)$shift['id_shift'];
        $placeholder['user_list'][$id_shift_day][$id_shift] = Tables\ShiftUserMaps::select_all($database_pdo, $id_shift_day, $id_shift);
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);