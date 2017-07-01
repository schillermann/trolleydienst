<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';
$render_page = include 'includes/render_page.php';

$page_file = '';
$placeholder = array();

if(isset($_POST['save'])) {

    $username = include 'filters/post_username.php';

    if(Tables\Users::is_username($database_pdo, $username)) {
        $placeholder['message']['error'] = 'Der Benutzername ist bereits vergeben!';
    } else {
        $get_password = require 'modules/random_string.php';
        $password = $get_password(8);
        $email = include 'filters/post_email.php';

        $user = new Models\User(
            0,
            include 'filters/post_firstname.php',
            include 'filters/post_lastname.php',
            $email,
            $username,
            $password,
            include 'filters/post_is_active.php',
            include 'filters/post_is_admin.php',
            include 'filters/post_is_literature_cart.php',
            include 'filters/post_is_literature_table.php',
            include 'filters/post_phone.php',
            include 'filters/post_mobile.php',
            include 'filters/post_congregation.php',
            include 'filters/post_language.php',
            include 'filters/post_note.php'
        );
    }


    if(Tables\Users::is_username($database_pdo, $username))
        $placeholder['message']['error'] = 'Der Benutzername ist bereits vergeben!';
    elseif (!Tables\Users::insert($database_pdo, $user))
        $placeholder['message']['error'] = 'Der Teilnehmer konnte nicht angelegt werden!';

    if(empty($placeholder['message']['error'])) {
        $page_file = 'user-add-mail.php';

        $placeholder['email'] = $email;
        $placeholder['username'] = $username;
        $placeholder['password'] = $password;

        //TODO: Send mail to added user
    }
}

echo $render_page($placeholder, $page_file);