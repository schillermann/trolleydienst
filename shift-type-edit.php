<?php
if(!isset($_GET['id_shift_type'])) {
    header('location: shift-type.php');
    return;
}
$placeholder = require 'includes/init_page.php';
$id_shift_type = (int)$_GET['id_shift_type'];

if (isset($_POST['save'])) {
    $name = include 'filters/post_name.php';
	$shift_type_info = include 'filters/post_shift_type_info.php';
    $user_per_shift_max = (int)$_POST['user_per_shift_max'];

    if(Tables\ShiftTypes::update($database_pdo, $id_shift_type, $name, $shift_type_info, $user_per_shift_max))
        $placeholder['message']['success'] = 'Die Änderungen wurden gespeichert.';
    else
        $placeholder['message']['error'] = 'Die Änderungen konnten nicht gespeichert werden!';
} elseif (isset($_POST['delete'])) {
    if(Tables\ShiftTypes::delete($database_pdo, $id_shift_type)) {
        header('location: shift-type.php');
        return;
    }
}

$placeholder['shift_type'] = Tables\ShiftTypes::select($database_pdo, $id_shift_type);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);