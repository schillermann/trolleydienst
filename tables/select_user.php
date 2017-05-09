<?php
return function (\PDO $database, string $username, string $password): Models\User {

    $stmt_user_login = $database->prepare(
        'SELECT teilnehmernr AS id_user, vorname AS firstname, nachname AS surname, email,
        infostand AS literature_table,
        trolley AS literature_cart,
        admin AS admin
        FROM teilnehmer
        WHERE username = :username
        AND pwd = :password'
    );

    $stmt_user_login->execute(
        array(
            ':username' => $username,
            ':password' => md5($password)
        )
    );
    return $stmt_user_login->fetchObject('Models\User');
};