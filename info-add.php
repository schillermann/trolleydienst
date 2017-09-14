<?php
$placeholder = require 'includes/init_page.php';

if(isset($_POST['file_label']) && !empty($_POST['file_label'])) {

    $convert_megabyte_in_byte = include 'modules/convert_megabyte_in_byte.php';
    $upload_file = include 'modules/upload_file.php';

    $file_size_max = $convert_megabyte_in_byte(UPLOAD_SIZE_MAX_IN_MEGABYTE);
    $file_types_allow = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf');

    $file_hash = uniqid();
    $file_hash .= ".";
    $file_hash .= pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    if(!$upload_file($file_hash, 'uploads/', $file_size_max, $file_types_allow))
        $placeholder['message']['error'] = 'Die Info konnte nicht hochgeladen werden!';
    else {
        $file_label = include 'filters/post_file_label.php';
        $placeholder['message'] = array();

        if(Tables\Infos::insert($database_pdo, $file_label, $file_hash))
            $placeholder['message']['success'] = 'Die Datei wurde hochgeladen.';
        else
            $placeholder['message']['error'] = 'Die Datei konnte nicht hochgeladen werden!';
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);