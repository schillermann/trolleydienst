<?php
require 'includes/init_page.php';

$select_user_list = include 'tables/select_users_list.php';
$user_list = $select_user_list(include 'includes/database_pdo.php');

$placeholder = array();
$placeholder['user_list'] = $user_list;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);