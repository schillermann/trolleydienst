<?php
require 'includes/init_page.php';

$template_placeholder = array();
$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);