<?php
if(!isset($_GET['id_user']))
    header('location: user.php');

require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';

$id_user = (int)$_GET['id_user'];
$select_user = include 'tables/select_users.php';
$user = $select_user($database_pdo, $id_user);

$placeholder = array();

if (isset($_POST['save'])) {
    $user->set_firstname($_POST['firstname']);
    $user->set_surname($_POST['surname']);
    $user->set_email($_POST['email']);
    $user->set_username($_POST['username']);
    $user->set_mobile($_POST['mobile']);
    $user->set_phone($_POST['phone']);
    $user->set_congregation($_POST['congregation']);
    $user->set_language($_POST['language']);
    $user->set_active((bool)$_POST['active']);
    $user->set_literature_table($_POST['literature_table']);
    $user->set_literature_cart($_POST['literature_cart']);
    $user->set_admin($_POST['admin']);
    $user->set_note_admin($_POST['note_admin']);

    $update_user = include 'tables/update_users.php';

    if($update_user($database_pdo, $user))
        $placeholder['message']['success'] = 'Die Teilnehmer Daten wurde geändert.';
    else
        $placeholder['message']['error'] = 'Die Teilnehmer Daten konnten nicht geändert werden!';
} elseif (isset($_POST['delete'])) {
    $delete_user = include 'tables/delete_users.php';
    if($delete_user($database_pdo, $id_user))
        header('location: user.php');
} elseif(isset($_POST['password_save']) && !empty($_POST['password'])) {

    if($_POST['password'] == $_POST['password_repeat'])
        if(Tables\Users::update_password_by_id_user($database_pdo, $id_user, $_POST['password']))
            $placeholder['message']['success'] = 'Dein Passwort wurde geändert.';
        else
            $placeholder['message']['error'] = 'Dein Passwort konnte nicht geändert werden!';
    else
        $placeholder['message']['error'] = 'Passwörter stimmen nicht überein!';
}

$placeholder['user'] = $user;

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);