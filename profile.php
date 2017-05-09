<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';
$template_placeholder = array();

if(isset($_POST['profile_save'])) {

    $user = new Models\User();
    $user->set_id_user($_SESSION['id_user']);
    $user->set_firstname($_POST['firstname']);
    $user->set_surname($_POST['surname']);
    $user->set_email($_POST['email']);
    $user->set_phone($_POST['phone']);
    $user->set_mobile($_POST['mobile']);
    $user->set_shift_max($_POST['shift_max']);
    $user->set_note($_POST['note']);

    $update_user = include 'tables/update_user.php';
    $template_placeholder['profile_save'] = $update_user($database_pdo, $user);
}
elseif(isset($_POST['password_save'])) {

}

$select_user = include 'tables/select_user.php';
$user = $select_user($database_pdo, $_SESSION['id_user']);

$template_placeholder['user'] = $user;
$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);