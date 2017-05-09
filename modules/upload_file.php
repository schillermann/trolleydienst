<?php
return function (string $file_name, string $file_target_path, int $file_size_max_byte = 3145728, array $file_type_list_allow = array()): bool {
    if($_FILES['file']['error'] !== 0)
        return false;
    if(!empty($file_type_list_allow) && !in_array($_FILES['file']['type'], $file_type_list_allow))
        return false;

    if(strpos($_FILES['file']['type'], 'image') !== false && !getimagesize( $_FILES['file']["tmp_name"]))
        return false;

    if($_FILES['file']['size'] > $file_size_max_byte)
        return false;

    if(!is_dir($file_target_path))
        if(mkdir($file_target_path))
            return false;

    if(!move_uploaded_file($_FILES['file']["tmp_name"], $file_target_path . $file_name))
        return false;

    return true;
};