<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';

$get_file_list = include 'includes/get_file_list.php';
$file_list = $get_file_list($database_pdo);

$template_placeholder = array();
$template_placeholder['file_list'] = $file_list;
$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);