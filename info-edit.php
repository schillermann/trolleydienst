<?php
if(!isset($_GET['id_info'])) {
    header('location: info.php');
    return;
}

$placeholder = require 'includes/init_page.php';
$id_info = (int)$_GET['id_info'];

if(isset($_POST['delete'])) {

    $info = Tables\Infos::select($database_pdo, $id_info);

    if(unlink('uploads/' . $info['file_hash']))
        if(Tables\Infos::delete($database_pdo, $id_info)) {
            header('location: info.php');
            return;
        }
    else
        $placeholder['message']['error'] = 'Die Datei ' . $info['file_name'] . ' konnte nicht gelöscht werden!';
}
elseif (isset($_POST['save'])) {
    $info_label = include 'filters/post_info_label.php';
    $info_type = include 'filters/post_info_type.php';

    if($info_label && $info_type)
        if(Tables\Infos::update($database_pdo, $id_info, $info_label, $info_type))
            $placeholder['message']['success'] = 'Die Datei ' . $info_label . ' wurde geändert.';
        else
            $placeholder['message']['error'] = 'Die Datei ' . $info_label . ' konnte nicht geändert werden!';
}

$info = Tables\Infos::select($database_pdo, $id_info);
$placeholder['info'] = $info;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);