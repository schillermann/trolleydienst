<?php
if(!isset($_GET['id_file']))
    header('location: info.php');

require 'includes/init_page.php';

$database_pdo = include 'includes/database_pdo.php';
$select_info = include 'tables/select_infos.php';

$id_file = (int)$_GET['id_file'];

if(isset($_POST['delete'])) {

    $delete_info = include "tables/delete_infos.php";

    $info_file = $select_info($database_pdo, $id_file);
    $placeholder['delete_info_success'] = unlink('uploads/' . $info_file->get_file_hash());

    if($placeholder['delete_info_success'])
        if($delete_info($database_pdo, $id_file))
            header('location: info.php');
}
elseif (isset($_POST['save'])) {
    $file_label = filter_input(INPUT_POST, 'file_label', FILTER_SANITIZE_STRING);

    $file_type_options = array(
        'options' => array(
            'min_range' => -1,
            'max_range' => 2)
    );
    $file_type = filter_input(INPUT_POST, 'file_type', FILTER_VALIDATE_INT, $file_type_options);
    $placeholder = array();

    if($file_label != null && $file_type) {

        $file_label = filter_input(INPUT_POST, 'file_label', FILTER_SANITIZE_STRING);

        $update_info = include 'tables/update_infos.php';
        $placeholder['update_info_success'] = $update_info($database_pdo, $id_file, $file_label, (int)$_POST['file_type']);
    }
}

$info_file = $select_info($database_pdo, $id_file);
$placeholder['info_file'] = $info_file;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);