<?php
require 'includes/init_page.php';
$template_placeholder = array();

if(isset($_POST['file_label']) && !empty($_POST['file_label'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allow_file_type_list = array('jpg', 'png', 'gif');
    if (in_array($file_type, $allow_file_type_list))
        $check_file = getimagesize($_FILES["file"]["tmp_name"]);
    elseif ($file_type !== 'pdf')
        $check_file = FALSE;

    if($check_file === FALSE) {
        $template_placeholder['message'] = 'Nur die Datei Formate jpg, png, gif und pdf sind erlaubt!';
        $template_placeholder['message_class'] = 'success';
    }
    elseif (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $template_placeholder['message'] = 'Die Datei ' . basename( $_FILES['file']['name']). ' wurde hochgeladen.';
        $template_placeholder['message_class'] = 'error';
    }

}

$database_pdo = include 'includes/database_pdo.php';

$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);