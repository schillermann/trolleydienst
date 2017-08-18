<?php
$placeholder = require 'includes/init_page.php';

$placeholder['recipient'] = '';
$placeholder['subject'] = '';
$placeholder['text'] = '';

if(isset($_POST['send']) && !empty($_POST['subject']) && !empty($_POST['text'])) {

    $placeholder['recipient'] = $_POST['recipient'];
    $placeholder['subject'] = $_POST['subject'];
    $placeholder['text'] = $_POST['text'];

    $placeholder['user_list'] = Tables\Users::select_all_email($database_pdo, $placeholder['recipient']);

    if(true)
        $placeholder['message']['success'] = 'E-Mail wurde versendet an:';
    else
        $placeholder['message']['error'] = 'E-Mail konnte nicht versendet werden!';
} else {
    $placeholder['TEAM_NAME'] = TEAM_NAME;
    $placeholder['CONGREGATION_NAME'] = CONGREGATION_NAME;
    $placeholder['EMAIL_ADDRESS_REPLY'] = EMAIL_ADDRESS_REPLY;
    $placeholder['WEBSITE_LINK'] = $_SERVER['SERVER_NAME'];

    $placeholder['template_email_info'] = Tables\Templates::select($database_pdo, Tables\Templates::EMAIL_INFO);
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);