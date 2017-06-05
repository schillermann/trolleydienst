<?php
return function (string $file_url, array $placeholder_with_content = array()):string {

    if(!($file_content = file_get_contents($file_url)))
        return '';

    return strtr($file_content, $placeholder_with_content);
};