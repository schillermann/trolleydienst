<?php
return function (\PDO $database, string $recipient): array {

    $literature_table = 'AND infostand > 0';
    $literature_cart = 'AND trolley > 0';

    if($recipient == Enum\Recipient::LITERATURE_TABLE)
        $literature_cart = '';
    elseif ($recipient == Enum\Recipient::LITERATURE_CART)
        $literature_table = '';

    $stmt_user_email_list = $database->query(
        'SELECT vorname AS firstname, nachname AS surname, email FROM teilnehmer WHERE status = 0 ' .
        $literature_table .
        $literature_cart
    );

    return $stmt_user_email_list->fetchAll();
};