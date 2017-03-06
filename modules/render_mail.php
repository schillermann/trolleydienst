<?php
return function (string $template_file, array $placeholder): array {

    $email_data = array();
    $email_data['subject'] = '';
    $email_data['message'] = '';

    $template_mail = file_get_contents($template_file);
    if($template_mail === FALSE)
        return $email_data;

    $email_data['subject'] = strstr($template_mail, PHP_EOL, true);
    $email_message_raw = trim(strstr($template_mail,PHP_EOL), PHP_EOL);
    $email_data['message'] = strtr($email_message_raw, $placeholder);

    return $email_data;
};