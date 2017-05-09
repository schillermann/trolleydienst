<?php
return function (\PDO $database, int $id_user): Models\User {

    $stmt_user_login = $database->prepare(
        'SELECT teilnehmernr AS id_user, vorname AS firstname, nachname AS surname, email, username,
        infostand AS literature_table, trolley AS literature_cart, admin AS admin, Telefonnr AS phone,
        Handy AS mobile, MaxSchichten AS shift_max, TeilnehmerBemerkung AS note
        FROM teilnehmer
        WHERE teilnehmernr = :id_user'
    );

    $stmt_user_login->execute(
        array(':id_user' => $id_user)
    );
    return $stmt_user_login->fetchObject('Models\User');
};