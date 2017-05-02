<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';
$template_placeholder = array();

if(isset($_POST['file_label']) && !empty($_POST['file_label'])) {

    $convert_megabyte_in_byte = include 'modules/convert_megabyte_in_byte.php';
    $upload_file = include 'modules/upload_file.php';

    $file_size_max = $convert_megabyte_in_byte(UPLOAD_SIZE_MAX_IN_MEGABYTE);
    $file_types_allow = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf');

    $template_placeholder['file_uploaded'] = $upload_file($_FILES["file"], 'uploads/', $file_size_max, $file_types_allow);

    $stmt_id_file_last = $database_pdo->prepare(
        'SELECT coalesce(MAX(ID),0) + 1 AS ID FROM newsletter'
    );

    $stmt_id_file_last->execute();
    $id_file_last = $stmt_id_file_last->fetch();
    $id_file = ($id_file_last['ID'] == 0) ? 1 : (int)$id_file_last['ID'];

    $stmt_insert_file = $database_pdo->prepare(
        'INSERT INTO newsletter (ID, Bezeichnung, Dateiname, ServerPfadname, newsletter_typ)
            VALUES (:id_file, :label_file, :name_file, :file_name_hash, :type_news)'
    );

    $file_name_hash = uniqid();
    $file_name_hash .= ".";
    $file_name_hash .= pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    $stmt_insert_file->execute(
        array(
            ':id_file' => $id_file,
            ':label_file' => filter_var($_POST['file_label'], FILTER_SANITIZE_STRING),
            ':name_file' => $_FILES["file"]["name"],
            ':file_name_hash' => $file_name_hash,
            ':type_news' => (int)$_POST['file_type']
        )
    );
    if ($stmt_insert_file->rowCount() != 1)
        exit('Infos konnte nicht eingefügt werden!');
}

$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);