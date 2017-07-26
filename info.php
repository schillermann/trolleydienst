<?php
$placeholder = require 'includes/init_page.php';
$file_list = Tables\Infos::select_all($database_pdo);

$placeholder['file_list'] = $file_list;
$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);