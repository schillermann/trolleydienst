<?php
return function (array $file, string $file_target_path, int $file_size_max_byte = 3145728, array $file_type_list_allow = array()): bool {
    if($file['error'] !== 0)
        return FALSE;
    if(!empty($file_type_list_allow) && !in_array($file['type'], $file_type_list_allow))
        return FALSE;

    if(strpos($file['type'], 'image') !== FALSE && !getimagesize($file["tmp_name"]))
        return FALSE;

    if($file['size'] > $file_size_max_byte)
        return FALSE;

    if(!move_uploaded_file($file["tmp_name"], $file_target_path . $file['name']))
        return FALSE;

    return TRUE;
};