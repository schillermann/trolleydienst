<?php
return function (\PDO $database, string $username, string $password): int {

    $stmt_user_login = $database->prepare(
        'SELECT teilnehmernr AS id_user
        FROM teilnehmer
        WHERE username = :username
        AND pwd = :password'
    );

    $stmt_user_login->execute(
        array(
            ':username' => $username,
            ':password' => $password
        )
    );
    $user_id = $stmt_user_login->fetch();

    return (isset($user_id[0])) ? (int)$user_id[0] : 0;
};