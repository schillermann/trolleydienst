<?php
/**
 * return string Class name active or empty string
 */
return function (string $page_file, string $query_string = ''): string {

    $is_active_page_file = basename($_SERVER['PHP_SELF']) === $page_file;
    if(empty($query_string))
        return ($is_active_page_file)? 'active' : '';

    if($is_active_page_file && $query_string === $_SERVER['QUERY_STRING'])
        return 'active';
    return '';
};