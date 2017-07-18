<?php
require 'includes/init_page.php';

$database_pdo = Tables\Database::get_connection();
$placeholder = array();
$placeholder['shift_type_list'] = Tables\ShiftTypes::select_all($database_pdo);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);