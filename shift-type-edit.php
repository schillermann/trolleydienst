<?php
if(!isset($_GET['id_shift_type'])) {
    header('location: shift-type.php');
    return;
}
require 'includes/init_page.php';

$id_shift_type = (int)$_GET['id_shift_type'];

$database_pdo = Tables\Database::get_connection();
$placeholder = array();

if (isset($_POST['save'])) {
    $name = include 'filters/post_name.php';
    $user_per_shift_max = (int)$_POST['user_per_shift_max'];

    if(Tables\ShiftTypes::update($database_pdo, $id_shift_type, $name, $user_per_shift_max))
        $placeholder['message']['success'] = 'Die Änderungen wurden gespeichert.';
    else
        $placeholder['message']['error'] = 'Die Änderungen konnten nicht gespeichert werden!';
} elseif (isset($_POST['delete'])) {
    if(Tables\ShiftTypes::delete($database_pdo, $id_shift_type)) {
        header('location: shift-type.php');
        return;
    }
}

$shift_type = Tables\ShiftTypes::select($database_pdo, $id_shift_type);

$placeholder['name'] = $shift_type['name'];
$placeholder['user_per_shift_max'] = $shift_type['user_per_shift_max'];

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);