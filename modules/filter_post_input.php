<?php
return function (string $filter_folder = 'filters'): array {

    $return_value_list = array();

    foreach ($_POST as $type => $value) {
        $filter_file = $filter_folder . '/post_' . $type . '.php';
        if(file_exists($filter_file))
            $return_value_list[$type] = include $filter_file;
    }

    return $return_value_list;
};