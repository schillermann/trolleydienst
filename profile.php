<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';
$placeholder = array();

$select_user = include 'tables/select_users.php';
$user = $select_user($database_pdo, $_SESSION['id_user']);

if(isset($_POST['profile_save'])) {

    $user->set_firstname($_POST['firstname']);
    $user->set_surname($_POST['surname']);
    $user->set_email($_POST['email']);
    $user->set_username($_POST['username']);
    $user->set_phone($_POST['phone']);
    $user->set_mobile($_POST['mobile']);
    $user->set_congregation($_POST['congregation']);
    $user->set_language($_POST['language']);
    $user->set_shift_max((int)$_POST['shift_max']);
    $user->set_note_user($_POST['note']);

    $update_user = include 'tables/update_users.php';
    if($update_user($database_pdo, $user))
        $placeholder['message']['success'] = 'Dein Profil wurde gespeichert.';
    else
        $placeholder['message']['error'] = 'Dein Profil konnte nicht gespeichert werden!';
}
elseif(isset($_POST['password_save']) && !empty($_POST['password'])) {

    if($_POST['password'] == $_POST['password_repeat']) {
        $update_user_password = include 'tables/update_users_password.php';
        if($update_user_password($database_pdo, $_SESSION['id_user'], md5($_POST['password'])))
            $placeholder['message']['success'] = 'Dein Passwort wurde geändert.';
        else
            $placeholder['message']['error'] = 'Dein Passwort konnte nicht geändert werden!';
    } else {
        $placeholder['message']['error'] = 'Passwörter stimmen nicht überein!';
    }
}

$placeholder['user'] = $user;
$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);