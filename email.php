<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';

$placeholder = array();
$placeholder['recipient'] = '';
$placeholder['subject'] = '';
$placeholder['text'] = '';

if(isset($_POST['send']) && !empty($_POST['subject']) && !empty($_POST['text'])) {

    $placeholder['recipient'] = $_POST['recipient'];
    $placeholder['subject'] = $_POST['subject'];
    $placeholder['text'] = $_POST['text'];


    $select_user_email_list = include 'tables/select_users_email_list.php';

    $placeholder['user_list'] = $select_user_email_list($database_pdo, $placeholder['recipient']);

    if(true)
        $placeholder['message']['success'] = 'E-Mail wurde versendet an:';
    else
        $placeholder['message']['error'] = 'E-Mail konnte nicht versendet werden!';
} else {
    $placeholder['TEAM_NAME'] = TEAM_NAME;
    $placeholder['CONGREGATION_NAME'] = CONGREGATION_NAME;
    $placeholder['EMAIL_REPLY_TO_ADDRESS'] = EMAIL_REPLY_TO_ADDRESS;
    $placeholder['WEBSITE_LINK'] = $_SERVER['SERVER_NAME'];

    $render_template_static = include 'modules/render_template_static.php';
    $placeholder['text'] = $render_template_static('templates/emails/mail.txt', $placeholder);
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);