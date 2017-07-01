<?php
if(!isset($_GET['id_info']))
    header('location: info.php');

require 'includes/init_page.php';

$database_pdo = include 'includes/database_pdo.php';
$placeholder = array();
$id_info = (int)$_GET['id_info'];

if(isset($_POST['delete'])) {

    $info = Tables\Infos::select($database_pdo, $id_info);
    $placeholder['delete_info_success'] = unlink('uploads/' . $info['file_hash']);

    if($placeholder['delete_info_success'])
        if(Tables\Infos::delete($database_pdo, $id_info))
            header('location: info.php');
}
elseif (isset($_POST['save'])) {
    $info_label = include 'filters/post_info_label.php';
    $info_type = include 'filters/post_info_type.php';

    if($info_label && $info_type)
        $placeholder['update_info_success'] = Tables\Infos::update($database_pdo, $id_info, $info_label, $info_type);
}

$info = Tables\Infos::select($database_pdo, $id_info);
$placeholder['info'] = $info;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);