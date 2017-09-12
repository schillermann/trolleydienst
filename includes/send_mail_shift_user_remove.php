<?php
return function (\DateTime $shift_datetime_from, \DateTime $shift_datetime_to, string $name): bool {

    $placeholder = array(
        'SHIFT_DATE' => $shift_datetime_from->format('d.m.Y'),
        'SHIFT_TIME_FROM' => $shift_datetime_from->format('H:i'),
        'SHIFT_TIME_TO' => $shift_datetime_to->format('H:i'),
        'NAME' => $name
    );

    $render_mail = include 'modules/render_mail.php';
    $email_data = $render_mail('templates/emails/shift_user_remove.txt', $placeholder);
    $header = include 'includes/get_mail_header_plain.php';

    return mail(EMAIL_SUPPORT, $email_data['subject'], $email_data['message'], $header);
};