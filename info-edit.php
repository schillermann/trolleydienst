<?php
if(!isset($_GET['id_info'])) {
    header('location: info.php');
    return;
}

$placeholder = require 'includes/init_page.php';
$id_info = (int)$_GET['id_info'];

if(isset($_POST['delete'])) {

    $info = Tables\Infos::select($database_pdo, $id_info);

    if(unlink('uploads/' . $info['file_name_hash']))
        if(Tables\Infos::delete($database_pdo, $id_info)) {
            header('location: info.php');
            return;
        }
    else
        $placeholder['message']['error'] = 'Die Datei ' . $info['file_name_hash'] . ' konnte nicht gelöscht werden!';
}
elseif (isset($_POST['save'])) {
    $file_label = include 'filters/post_file_label.php';

    if($file_label)
        if(Tables\Infos::update($database_pdo, $id_info, $file_label))
            $placeholder['message']['success'] = 'Die Datei wurde in "' . $file_label . '" umbenannt.';
        else
            $placeholder['message']['error'] = 'Die Datei konnte nicht in "' . $file_label . '" umbennant werden!';
}

$info = Tables\Infos::select($database_pdo, $id_info);
$placeholder['info'] = $info;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);