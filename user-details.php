<?php
if(!isset($_GET['id_user'])) {
    header('location: shift.php');
    return;
}

require 'includes/init_page.php';
$database_pdo = Tables\Database::get_connection();

$id_user = (int)$_GET['id_user'];
$user = Tables\Users::select_user($database_pdo, $id_user);

$placeholder = array();
$placeholder['user'] = $user;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);