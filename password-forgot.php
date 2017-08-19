<?php
spl_autoload_register();
include 'config.php';
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

        if(Tables\Users::update_password($database_pdo, $id_user, $new_password)) {

            $user = Tables\Users::select_firstname_and_lastname($database_pdo, $id_user);
            $email_template = Tables\Templates::select($database_pdo, Tables\Templates::EMAIL_PASSWORD_FORGOT);

            $subject_replace_with = array(
                'APPLICATION_NAME' => APPLICATION_NAME,
                'CONGREGATION_NAME' => CONGREGATION_NAME
            );
            $email_subject = strtr($email_template['subject'], $subject_replace_with);

            $message_replace_with = array(
                'FIRSTNAME' => $user['firstname'],
                'LASTNAME' => $user['lastname'],
                'PASSWORD' => $new_password
            );
            $email_message = strtr($email_template['message'], $message_replace_with);

            $send_mail_plain = include 'modules/send_mail_plain.php';

            if($send_mail_plain($send_to_email, $email_subject, $email_message))
                $placeholder['message']['success'] = 'Dein neues Passwort wurde an <b>' . $send_to_email . '</b> versandt.';
        } else {
            $placeholder['message']['error'] = 'Dein Passwort konnte nicht geändert werden!';
        }
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);