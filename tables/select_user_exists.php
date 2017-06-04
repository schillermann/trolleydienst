<?php
return function (\PDO $database, string $username): bool {

    $stmt_user_exists = $database->prepare(
        'SELECT username FROM teilnehmer WHERE username = :username'
    );

    $stmt_user_exists->execute(
        array(':username' => $username)
    );
    return (bool)$stmt_user_exists->rowCount();
};