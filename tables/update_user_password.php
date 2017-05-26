<?php
return function (\PDO $database, int $id_user, string $password): bool {

    $stmt_user_password = $database->prepare(
        'UPDATE teilnehmer
        SET pwd= :password
        WHERE teilnehmernr = :id_user'
    );

    $stmt_user_password->execute(
        array(
            ':password' => $password,
            ':id_user' => $id_user
        )
    );
    return $stmt_user_password->rowCount() == 1;
};