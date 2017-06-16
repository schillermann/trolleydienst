<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';
$select_user = include 'tables/select_users.php';
$placeholder = array();

if(isset($_POST['profile_save'])) {

    $profile_filter_post_input = include 'modules/filter_post_input.php';
    $profile_update = new Models\Profile($_SESSION['id_user'], $profile_filter_post_input());

    if(Tables\Users::update_profile_by_id_user($database_pdo, $profile_update))
        $placeholder['message']['success'] = 'Dein Profil wurde gespeichert.';
    else
        $placeholder['message']['error'] = 'Dein Profil konnte nicht gespeichert werden!';
}
elseif(isset($_POST['password_save']) && !empty($_POST['password'])) {

    if($_POST['password'] == $_POST['password_repeat'])
        if(Tables\Users::update_password_by_id_user($database_pdo, $_SESSION['id_user'], $_POST['password']))
            $placeholder['message']['success'] = 'Dein Passwort wurde geändert.';
        else
            $placeholder['message']['error'] = 'Dein Passwort konnte nicht geändert werden!';
    else
        $placeholder['message']['error'] = 'Passwörter stimmen nicht überein!';
}

$placeholder['profile'] = Tables\Users::select_profile_by_id_user($database_pdo, $_SESSION['id_user']);
$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);