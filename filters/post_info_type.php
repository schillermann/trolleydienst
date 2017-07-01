<?php
$file_type_options = array(
    'options' => array(
        'min_range' => -1,
        'max_range' => 2)
);
return filter_input(INPUT_POST, 'info_type', FILTER_VALIDATE_INT, $file_type_options);