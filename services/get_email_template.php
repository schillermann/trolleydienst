<?php
/**
 * return array('subject' => '...', 'message' => '...')
 */
return function (\PDO $connection, string $template_name = Tables\Templates::EMAIL_INFO): array {
    $template = Tables\Templates::select($connection, $template_name);

    $replace_with = array(
        'TEAM_NAME' => TEAM_NAME,
        'APPLICATION_NAME' => APPLICATION_NAME,
        'CONGREGATION_NAME' => CONGREGATION_NAME,
        'EMAIL_ADDRESS_REPLY' => EMAIL_ADDRESS_REPLY,
        'WEBSITE_LINK' => $_SERVER['SERVER_NAME']
    );

    $template_placeholder_replaced = array();
    $template_placeholder_replaced['subject'] = strtr($template['subject'], $replace_with);

    if(strpos($template['message'], 'SIGNATURE') !== false) {
        $template_signature = Tables\Templates::select($connection, Tables\Templates::EMAIL_SIGNATURE);
        $replace_with['SIGNATURE'] =  strtr($template_signature['message'], $replace_with);
    }

    $template_placeholder_replaced['message'] = strtr($template['message'], $replace_with);

    return $template_placeholder_replaced;
};