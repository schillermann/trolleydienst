<?php
return function (string $to, array $placeholder): bool {

    $template_file_pathinfo = pathinfo(basename($_SERVER['SCRIPT_NAME']));
    $template_file_path = 'templates/emails/' . $template_file_pathinfo['filename'] . '.txt';

    $render_email_template = include 'modules/render_template_static.php';
    $email_template = $render_email_template($template_file_path, $placeholder);

    $email_subject = strstr($email_template, PHP_EOL, true);
    $email_message = trim(strstr($email_template,PHP_EOL), PHP_EOL);

    $placeholder_signature = array(
        'APPLICATION_NAME' => APPLICATION_NAME,
        'TEAM_NAME' => TEAM_NAME,
        'CONGREGATION_NAME' => CONGREGATION_NAME,
        'EMAIL_SUPPORT' => EMAIL_SUPPORT,
        'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME']
    );

    $email_message .= $render_email_template('templates/emails/signature.txt', $placeholder_signature);

    $send_mail_plain = include 'modules/send_mail_plain.php';
    return $send_mail_plain($to, $email_subject, $email_message);
};