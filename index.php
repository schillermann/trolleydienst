<?php
session_start();

if(isset($_GET['logout'])) {
    $_SESSION = array();
    header('location: /');
}

if(isset($_SESSION) && !empty($_SESSION))
    header('location: shift.php');

$template_placeholder = array();

if(isset($_POST['username']) && isset($_POST['password'])) {

    $database_pdo = include 'includes/database_pdo.php';
    $check_login = include 'includes/check_login.php';

    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

    if($check_login($database_pdo, $username, $_POST['password']))
        header('location: shift.php');
    else
        $template_placeholder['error_message'] = TRUE;
}

$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);
?>