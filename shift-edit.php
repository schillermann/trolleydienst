<?php
if(!isset($_GET['id_shift_day'])) {
    header('location: shift.php');
    return;
}

require 'includes/init_page.php';
$database_pdo = Tables\Database::get_connection();
$placeholder = array();

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);