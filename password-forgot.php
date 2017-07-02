<?php
spl_autoload_register();
$database_pdo = Tables\Database::get_connection();
$placeholder = array();

if(isset($_POST['password_reset'])) {

    $username = include 'filters/post_username.php';
    $send_to_email = include 'filters/post_email.php';

    $id_user = Tables\Users::select_id_user($database_pdo, $username, $send_to_email);

    if($id_user == 0) {
        $placeholder['message']['error'] = 'Benutzername oder E-Mail existiert nicht!';
    }
    else {
        $generate_password = include 'helpers/generate_password.php';
        $new_password = $generate_password();

        if(Tables\Users::update_password($database_pdo, $id_user, md5($new_password))) {

            $user = Tables\Users::select_firstname_and_lastname($database_pdo, $id_user);

            $email_placeholder = array(
                'FIRSTNAME' => $user['firstname'],
                'LASTNAME' => $user['lastname'],
                'PASSWORD' => $new_password
            );

            $send_mail = include 'services/send_mail.php';

            if($send_mail($send_to_email, $email_placeholder))
                $placeholder['message']['success'] = 'Dein neues Passwort wurde an <b>' . $send_to_email . '</b> versandt.';
        } else {
            $placeholder['message']['error'] = 'Dein Passwort konnte nicht geändert werden!';
        }
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);