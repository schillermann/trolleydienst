<?php
if(!isset($_GET['id_shift_day'])) {
    header('location: shift.php');
    return;
}
$id_shift_day = (int)$_GET['id_shift_day'];
$placeholder = require 'includes/init_page.php';

if (isset($_POST['save'])) {
    $place = include 'filters/post_place.php';
    if(Tables\ShiftsDays::update($database_pdo, $id_shift_day, $place))
        $placeholder['message']['success'] = 'Der Ort wurden geändert.';
    else
        $placeholder['message']['error'] = 'Der Ort konnten nicht geändert werden!';
} elseif (isset($_POST['delete'])) {

}

$placeholder['place'] = Tables\ShiftsDays::select_place($database_pdo, $id_shift_day);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);