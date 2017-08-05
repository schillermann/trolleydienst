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

    if(Tables\ShiftUserMaps::delete($database_pdo, (int)$_POST['id_shift'], $_SESSION['id_user'], (int)$_POST['position'])) {

        $placeholder['message']['success'] = 'Die Bewerbung von ' . $_SESSION['name'] . ' wurde zurück gezogen.';

        Tables\History::insert(
            $database_pdo,
            $_SESSION['id_user'],
            Tables\History::SHIFT_WITHDRAWN_SUCCESS,
            $placeholder['message']['success']
        );
    } else {
        $placeholder['message']['error'] = 'Die Bewerbung von ' . $_SESSION['name'] . ' konnte nicht zurück gezogen werden!';

        Tables\History::insert(
            $database_pdo,
            $_SESSION['id_user'],
            Tables\History::SHIFT_WITHDRAWN_SUCCESS,
            $placeholder['message']['error']
        );
    }
}
elseif (isset($_POST['promote_user'])) {

    $id_user = (int)$_POST['id_user'];
    $user_name = Tables\Users::select_user_name($database_pdo, $id_user);

    if(Tables\ShiftUserMaps::insert($database_pdo, (int)$_POST['id_shift'], $id_user, (int)$_POST['position'])) {

        $placeholder['message']['success'] = 'Die Bewerbung für ' . $user_name . ' wurde angenommen.';

        Tables\History::insert(
            $database_pdo,
            $_SESSION['id_user'],
            Tables\History::SHIFT_PROMOTE_SUCCESS,
            $placeholder['message']['success']
        );
    }
    else {
        $placeholder['message']['error'] = 'Die Bewerbung von ' . $user_name . ' konnte nicht angenommen werden!';

        Tables\History::insert(
            $database_pdo,
            $_SESSION['id_user'],
            Tables\History::SHIFT_PROMOTE_SUCCESS,
            $placeholder['message']['error']
        );
    }
}

$placeholder['user_per_shift_max'] = Tables\ShiftTypes::select_user_per_shift_max($database_pdo, $id_shift_type);

$user_list = Tables\Users::select_all_without_user($database_pdo, $_SESSION['id_user']);
$get_user_promote_list = include 'helpers/get_user_promote_list.php';
$placeholder['user_promote_list'] = $get_user_promote_list($user_list);
$placeholder['id_shift_type'] = $id_shift_type;

$get_shifts_with_users = include 'services/get_shifts_with_users.php';
$placeholder['shift_day'] = $get_shifts_with_users($database_pdo, $id_shift_type);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);