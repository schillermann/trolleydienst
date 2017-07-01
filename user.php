<?php
require 'includes/init_page.php';

$user_list = Tables\Users::select_all(include 'includes/database_pdo.php');

$placeholder = array();
$placeholder['user_list'] = $user_list;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);