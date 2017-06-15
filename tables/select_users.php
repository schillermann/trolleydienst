<?php
return function (\PDO $database, int $id_user): Models\User {

    $stmt_user_login = $database->prepare(
        'SELECT teilnehmernr AS id_user, status AS active, vorname AS firstname, nachname AS surname, email, username,
        infostand AS literature_table, trolley AS literature_cart, admin AS admin, Telefonnr AS phone,
        Handy AS mobile, versammlung AS congregation, sprache AS language, MaxSchichten AS shift_max, Bemerkung AS note_admin, TeilnehmerBemerkung AS note_user
        FROM teilnehmer
        WHERE teilnehmernr = :id_user'
    );

    $stmt_user_login->execute(
        array(':id_user' => $id_user)
    );
    return $stmt_user_login->fetchObject('Models\User');
};