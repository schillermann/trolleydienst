<?php
$placeholder = require 'includes/init_page.php';

$placeholder['email_address_from'] = EMAIL_ADDRESS_FROM;
$placeholder['email_address_reply'] = EMAIL_ADDRESS_REPLY;
$placeholder['congregation_name'] = CONGREGATION_NAME;
$placeholder['application_name'] = APPLICATION_NAME;
$placeholder['team_name'] = TEAM_NAME;

if (isset($_POST['save_email_placeholder'])) {

    $email_address_from = include 'filters/post_email_address_from.php';
    $email_address_reply = include 'filters/post_email_address_reply.php';
    $congregation_name = include 'filters/post_congregation_name.php';
    $application_name = include 'filters/post_application_name.php';
    $team_name = include 'filters/post_team_name.php';

    $write_config_file = include 'modules/write_config_file.php';
    $config = array(
        'EMAIL_ADDRESS_FROM' => $email_address_from,
        'EMAIL_ADDRESS_REPLY' => $email_address_reply,
        'CONGREGATION_NAME' => $congregation_name,
        'APPLICATION_NAME' => $application_name,
        'TEAM_NAME' => $team_name,
        'UPLOAD_SIZE_MAX_IN_MEGABYTE' => UPLOAD_SIZE_MAX_IN_MEGABYTE,
		'BAN_TIME_IN_MINUTES' => BAN_TIME_IN_MINUTES,
		'LOGIN_FAIL_MAX' => LOGIN_FAIL_MAX
    );
    if($write_config_file($config)) {
        $placeholder['email_address_from'] = $email_address_from;
        $placeholder['email_address_reply'] = $email_address_reply;
        $placeholder['congregation_name'] = $congregation_name;
        $placeholder['application_name'] = $application_name;
        $placeholder['team_name'] = $team_name;

        $placeholder['message']['success'][] = 'Die E-Mail Platzhalter wurden in die Datei config.php geschrieben.';
    } else {
        $placeholder['message']['error'][] = 'Die E-Mail Platzhalter konnten nicht in die Datei config.php geschrieben werden!';
    }
} else if(isset($_POST['save_templates_email'])) {
    $template_email_info_subject = include 'filters/post_template_email_info_subject.php';
    $template_email_info_message = include 'filters/post_template_email_info_message.php';

    if(Tables\Templates::update($database_pdo, Tables\Templates::EMAIL_INFO, $template_email_info_message, $template_email_info_subject))
        $placeholder['message']['success'][] = 'Die Vorlage Info wurde gespeichert.';
    else
        $placeholder['message']['error'][] = 'Die Vorlage Info konnte nicht gespeichert werden!';

    $template_email_password_forgot_subject = include 'filters/post_template_email_password_forgot_subject.php';
    $template_email_password_forgot_message = include 'filters/post_template_email_password_forgot_message.php';

    if(Tables\Templates::update($database_pdo, Tables\Templates::EMAIL_PASSWORD_FORGOT, $template_email_password_forgot_message, $template_email_password_forgot_subject))
        $placeholder['message']['success'][] = 'Die Vorlage Passwort vergessen wurde gespeichert.';
    else
        $placeholder['message']['error'][] = 'Die Vorlage Passwort vergessen konnte nicht gespeichert werden!';

    $template_email_signature = include 'filters/post_template_email_signature.php';

    if(Tables\Templates::update($database_pdo, Tables\Templates::EMAIL_SIGNATURE, $template_email_signature))
        $placeholder['message']['success'][] = 'Die Vorlage Signatur wurde gespeichert.';
    else
        $placeholder['message']['error'][] = 'Die Vorlage Signatur konnte nicht gespeichert werden!';
}

$placeholder['template_email_info'] = Tables\Templates::select($database_pdo, Tables\Templates::EMAIL_INFO);
$placeholder['template_email_password_forgot'] = Tables\Templates::select($database_pdo, Tables\Templates::EMAIL_PASSWORD_FORGOT);
$placeholder['template_email_signature'] = Tables\Templates::select($database_pdo, Tables\Templates::EMAIL_SIGNATURE);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);