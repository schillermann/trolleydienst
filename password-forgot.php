<?php
spl_autoload_register();
$placeholder = array();

if(isset($_POST['password_reset'])) {

    $username = include 'filters/post_username.php';
    $email = include 'filters/post_email.php';

    $database_pdo = include 'includes/database_pdo.php';
    $select_users_id_user_by_username_and_email = include 'tables/select_users_id_user_by_username_and_email.php';
    $id_user = $select_users_id_user_by_username_and_email($database_pdo, $username, $email);

    if($id_user == 0) {
        $placeholder['message']['error'] = 'Benutzername oder E-Mail existiert nicht!';
    }
    else {
        $generate_password = include 'helpers/generate_password.php';
        $update_users_password = include 'tables/update_users_password.php';
        //TODO: Send Email
        if($update_users_password($database_pdo, $id_user, md5($generate_password())))
            $placeholder['message']['success'] = 'Dein neues Passwort wurde an <b>' . $email . '</b> versandt.';
        else
            $placeholder['message']['error'] = 'Dein Passwort konnte nicht geändert werden!';
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);