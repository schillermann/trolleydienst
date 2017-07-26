<?php
$placeholder = require 'includes/init_page.php';
$placeholder['user_list'] = Tables\Users::select_all(Tables\Database::get_connection());


$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);