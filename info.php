<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';

$get_file_list = include 'tables/select_file_list.php';
$file_list = $get_file_list($database_pdo);

$placeholder = array();
$placeholder['file_list'] = $file_list;
$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);