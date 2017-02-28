<?php
return function (array $template_placeholder = array()) : string {
    $navigation_config = include 'config_nav.php';

    $navigation_permission = include 'modules/navigation_permission.php';
    $role = (isset($_SESSION['role'])) ? $_SESSION['role'] : '';

    $layout_placeholder = array();
    $layout_placeholder['navigation'] = $navigation_permission($navigation_config, $role);

    $page_template = include 'modules/page_template.php';
    $layout_placeholder['content'] = $page_template($template_placeholder);

    $page_layout = include 'modules/page_layout.php';
    $page_layout($layout_placeholder);
};