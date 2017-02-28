<?php
return function (\PDO $database, string $username, string $password): bool {

    $stmt_user_login = $database->prepare(
        'SELECT teilnehmernr, vorname, nachname, email,
        coalesce(infostand, 0) AS literature_table,
        coalesce(trolley, 0) AS literature_cart,
        coalesce(admin, 0) AS admin
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
    $user = $stmt_user_login->fetch();

    if ($user) {
        $_SESSION['id_user'] = $user['teilnehmernr'];
        $_SESSION['name'] = $user['vorname'] . ' ' . $user['nachname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['literature_table'] = ($user['literature_table'] == 0) ? 0 : 1;
        $_SESSION['literature_cart'] = ($user['literature_cart'] == 0) ? 0 : 1;
        $_SESSION['role'] = ($user['admin'] == 1) ? 'admin' : 'user';

        $stmt_user_last_login = $database->prepare(
            'UPDATE
              teilnehmer
            SET
              LastLoginTime = NOW()
            WHERE
              teilnehmernr = :id_user'
        );

        $stmt_user_last_login->execute(
            array(':id_user' => $user['teilnehmernr'])
        );

        return TRUE;
    }
    else
    {
        return FALSE;
    }
};