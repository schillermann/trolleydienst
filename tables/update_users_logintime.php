<?php
return function (\PDO $database, int $id_user): bool {

    $stmt_user_last_login = $database->prepare(
        'UPDATE
              teilnehmer
            SET
              LastLoginTime = NOW()
            WHERE
              teilnehmernr = :id_user'
    );

    $stmt_user_last_login->execute(
        array(':id_user' => $id_user)
    );

    return $stmt_user_last_login->rowCount() == 1;
};