<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';
$render_page = include 'includes/render_page.php';

$page_file = '';
$placeholder = array();
$user = merge_input_with_user($_POST);

if(isset($_POST['save'])) {

    $get_password = require 'modules/random_string.php';
    $user_password = $get_password(8);
    $user->set_password($user_password);

    $select_user_exists = include 'tables/select_users_exists.php';
    $insert_user = include 'tables/insert_users.php';

    if($select_user_exists($database_pdo, $user->get_username()))
        $placeholder['message']['error'] = 'Der Benutzername ist bereits vergeben!';
    elseif (!$insert_user($database_pdo, $user))
        $placeholder['message']['error'] = 'Der Teilnehmer konnte nicht angelegt werden!';

    if(empty($placeholder['message']['error']))
        $page_file = 'user-add-mail.php';

    //TODO: Send mail to added user
}

$placeholder['user'] = $user;
echo $render_page($placeholder, $page_file);

function merge_input_with_user(array $input): Models\User {

    $firstname = (isset($input['firstname'])) ? $input['firstname'] : '';
    $surname = (isset($input['surname'])) ? $input['surname'] : '';
    $email = (isset($input['email'])) ? $input['email'] : '';
    $username = (isset($input['username'])) ? $input['username'] : '';
    $mobile = (isset($input['mobile'])) ? $input['mobile'] : '';
    $phone = (isset($input['phone'])) ? $input['phone'] : '';
    $congregation = (isset($input['congregation'])) ? $input['congregation'] : '';
    $language = (isset($input['language'])) ? $input['language'] : '';
    $is_active = (isset($input['is_active'])) ? (bool)$input['is_active'] : true;
    $literature_table =  (isset($input['literature_table'])) ? $input['literature_table'] : Enum\Status::ACTIVE;
    $literature_cart =  (isset($input['literature_cart'])) ? $input['literature_cart'] : Enum\Status::ACTIVE;
    $is_admin = (isset($input['is_admin'])) ? (bool)$input['is_admin'] : false;
    $note_admin = (isset($input['note_admin'])) ? $input['note_admin'] : '';

    $user = new Models\User();
    $user ->set_firstname($firstname);
    $user->set_surname($surname);
    $user->set_email($email);
    $user->set_username($username);
    $user->set_mobile($mobile);
    $user->set_phone($phone);
    $user->set_congregation($congregation);
    $user->set_language($language);
    $user->set_active($is_active);
    $user->set_literature_table($literature_table);
    $user->set_literature_cart($literature_cart);
    $user->set_admin($is_admin);
    $user->set_note_admin($note_admin);

    return $user;
}