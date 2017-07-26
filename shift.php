<?php
$placeholder = require 'includes/init_page.php';

if(!isset($_GET['id_shift_type'])) {
    $id_shift_type = Tables\ShiftTypes::select_first_id_shift_type($database_pdo);
    if($id_shift_type)
        header('location: shift.php?id_shift_type=' . $id_shift_type);
    else
        header('location: info.php');
    return;
}
$id_shift_type = (int)$_GET['id_shift_type'];

if(isset($_POST['delete_user'])) {

    if(Tables\ShiftUserMaps::delete($database_pdo, $_SESSION['id_user'], (int)$_POST['id_shift_day'], (int)$_POST['id_shift']))
        $placeholder['message']['success'] = 'Deine Bewerbung wurde zurück gezogen.';
    else
        $placeholder['message']['error'] = 'Deine Bewerbung konnte nicht zurück gezogen werden!';
}
elseif (isset($_POST['promote_user'])) {

    if(Tables\ShiftUserMaps::insert($database_pdo, (int)$_POST['id_user'], (int)$_POST['id_shift_day'], (int)$_POST['id_shift']))
        $placeholder['message']['success'] = 'Deine Bewerbung wurde angenommen.';
    else
        $placeholder['message']['error'] = 'Deine Bewerbung konnte nicht angenommen werden!';
}

$placeholder['user_per_shift_max'] = Tables\ShiftTypes::select_user_per_shift_max($database_pdo, $id_shift_type);

$user_list = Tables\Users::select_all_without_user($database_pdo, $_SESSION['id_user']);
$get_user_promote_list = include 'helpers/get_user_promote_list.php';
$placeholder['user_promote_list'] = $get_user_promote_list($user_list);

$placeholder['shiftday_list'] = Tables\ShiftsDays::select_all($database_pdo, $id_shift_type);

foreach ($placeholder['shiftday_list'] as $shift_day) {

    $id_shift_day = (int)$shift_day['id_shift_day'];
    $placeholder['shift_list'][$id_shift_day] = $shift_list = Tables\Shifts::select_all($database_pdo, $id_shift_day);

    foreach ($shift_list as $shift) {
        $id_shift = (int)$shift['id_shift'];
        $placeholder['user_list'][$id_shift_day][$id_shift] = Tables\ShiftUserMaps::select_all($database_pdo, $id_shift_day, $id_shift);
    }
}

$placeholder['id_shift_type'] = $id_shift_type;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);