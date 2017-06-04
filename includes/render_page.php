<?php
return function (array $placeholder = array(), string $file_name = '') : string {
    $navigation_config = include 'navigation.php';

    $navigation_permission = include 'modules/navigation_permission.php';
    $role = (isset($_SESSION['role'])) ? $_SESSION['role'] : '';

    $layout_placeholder = array();
    $layout_placeholder['navigation'] = $navigation_permission($navigation_config, $role);

    $page_file_name = (empty($file_name))? basename($_SERVER['SCRIPT_NAME']) : $file_name;
    $page_file_path = 'templates/pages/' . $page_file_name;
    $render_template = include 'modules/render_template.php';

    $layout_placeholder['content'] = $render_template($placeholder, $page_file_path);

    $layout_file = 'templates/layout.php';
    $page_layout = include 'modules/render_template.php';
    return $page_layout($layout_placeholder, $layout_file);
};