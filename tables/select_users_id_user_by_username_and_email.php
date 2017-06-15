<?php
return function (\PDO $database, string $username, string $email): int {

    $stmt_users_id_user = $database->prepare(
        'SELECT teilnehmernr AS id_user
        FROM teilnehmer
        WHERE username = :username
        AND email = :email'
    );

    $stmt_users_id_user->execute(
        array(
            ':username' => $username,
            ':email' => $email
        )
    );
    $user_id = $stmt_users_id_user->fetch();

    return (isset($user_id[0])) ? (int)$user_id[0] : 0;
};