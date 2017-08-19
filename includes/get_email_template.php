<?php return function (\PDO $connection): array {
    $template_email_info = Tables\Templates::select($connection, Tables\Templates::EMAIL_INFO);
    $template_email_signature = Tables\Templates::select($connection, Tables\Templates::EMAIL_SIGNATURE);

    $replace_with = array(
        'TEAM_NAME' => TEAM_NAME,
        'APPLICATION_NAME' => APPLICATION_NAME,
        'CONGREGATION_NAME' => CONGREGATION_NAME,
        'EMAIL_ADDRESS_REPLY' => EMAIL_ADDRESS_REPLY,
        'WEBSITE_LINK' => $_SERVER['SERVER_NAME']
    );

    $template_email_signature_message = strtr($template_email_signature['message'], $replace_with);

    $email =  array();
    $email['subject'] = strtr($template_email_info['subject'], $replace_with);
    $replace_with['SIGNATURE'] = $template_email_signature_message;
    $email['message'] = strtr($template_email_info['message'], $replace_with);

    return $email;
};