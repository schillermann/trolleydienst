<?php
require 'includes/init_page.php';

$select_user_list = include 'tables/select_user_list.php';
$user_list = $select_user_list(include 'includes/database_pdo.php');

$template_placeholder = array();
$template_placeholder['user_list'] = $user_list;

$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);