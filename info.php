<?php
require 'includes/init_page.php';
$database_pdo = Tables\Database::get_connection();
$file_list = Tables\Infos::select_all($database_pdo);

$placeholder = array();
$placeholder['file_list'] = $file_list;
$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);