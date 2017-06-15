<?php
if(!isset($_GET['id_user']))
    header('location: shift.php');

require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';

$id_user = (int)$_GET['id_user'];
$select_user = include 'tables/select_users.php';
$user = $select_user($database_pdo, $id_user);

$placeholder = array();
$placeholder['user'] = $user;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);