<?php
function check_login(\PDO $database): bool {

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
            ':username' => $_POST['login_name'],
            ':password' => md5($_POST['login_PWD'])
        )
    );
    $user = $stmt_user_login->fetch();

    if ($user)
    {
        $_SESSION['role'] = 'user';
        /*
        $_SESSION['ID'] = $user['teilnehmernr'];
        $_SESSION['Name'] = $user['vorname'] . ' ' . $user['nachname'];
        $_SESSION['eMail'] = $user['email'];
        $_SESSION['infostand'] = ($user['literature_table'] == 0) ? 0 : 1;
        $_SESSION['trolley'] = ($user['literature_cart'] == 0) ? 0 : 1;
        $_SESSION['admin'] = (int)$user['admin'];
*/
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
}