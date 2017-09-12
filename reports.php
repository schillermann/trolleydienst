<?php
$placeholder = require 'includes/init_page.php';

$placeholder['report_list'] = Tables\Reports::select_all($database_pdo, 1);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);