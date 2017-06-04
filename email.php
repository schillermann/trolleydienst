<?php
require 'includes/init_page.php';

$placeholder = array();
$placeholder['recipient'] = '';
$placeholder['subject'] = '';
$placeholder['text'] = '';

if(isset($_POST['send']) && !empty($_POST['subject']) && !empty($_POST['text'])) {

    $placeholder['recipient'] = $_POST['recipient'];
    $placeholder['subject'] = $_POST['subject'];
    $placeholder['text'] = $_POST['text'];

    $database_pdo = include 'includes/database_pdo.php';
    $select_user_email_list = include 'tables/select_user_email_list.php';

    $placeholder['user_list'] = $select_user_email_list($database_pdo, $placeholder['recipient']);

    if(true)
        $placeholder['message']['success'] = 'E-Mail wurde versendet an:';
    else
        $placeholder['message']['error'] = 'E-Mail konnte nicht versendet werden!';
}


$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);