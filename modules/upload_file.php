<?php
return function (string $file_name, string $file_target_path, int $file_size_max_byte = 3145728, array $file_type_list_allow = array()): bool {
    if($_FILES['file']['error'] !== 0)
        return FALSE;
    if(!empty($file_type_list_allow) && !in_array($_FILES['file']['type'], $file_type_list_allow))
        return FALSE;

    if(strpos($_FILES['file']['type'], 'image') !== FALSE && !getimagesize( $_FILES['file']["tmp_name"]))
        return FALSE;

    if($_FILES['file']['size'] > $file_size_max_byte)
        return FALSE;

    if(!is_dir($file_target_path))
        if(mkdir($file_target_path))
            return FALSE;

    if(!move_uploaded_file($_FILES['file']["tmp_name"], $file_target_path . $file_name))
        return FALSE;

    return TRUE;
};