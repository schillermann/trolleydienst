<?php
return function (array $template_placeholder = array()) : string {
    $navigation_config = include 'navigation.php';

    $navigation_permission = include 'modules/navigation_permission.php';
    $role = (isset($_SESSION['role'])) ? $_SESSION['role'] : '';

    $layout_placeholder = array();
    $layout_placeholder['navigation'] = $navigation_permission($navigation_config, $role);

    $template_file = 'templates/pages/' . basename($_SERVER['SCRIPT_NAME']);
    $page_template = include 'modules/render_template.php';

    $layout_placeholder['content'] = $page_template($template_placeholder, $template_file);

    $layout_file = 'templates/layout.php';
    $page_layout = include 'modules/render_template.php';
    return $page_layout($layout_placeholder, $layout_file);
};