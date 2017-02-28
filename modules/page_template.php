<?php
return function (array $placeholder = array(), string $template_file_path = NULL): string {

    if($template_file_path === NULL)
        $template_file_path = 'views/' . basename($_SERVER['SCRIPT_NAME']);

    ob_start();
    include $template_file_path;
    $page_content = ob_get_contents();
    ob_end_clean();
    return $page_content;
};