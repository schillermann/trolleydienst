<?php
include 'function.php';
$UserExists = -1;
$ShowPWDforgot = 1;
$user = NULL;

if (isset($_POST["PWDMail"])) {

    $username = filter_var($_POST['PWDLoginname'], FILTER_SANITIZE_STRING);
    $user_email = (string)filter_var($_POST['PWDMail'], FILTER_VALIDATE_EMAIL);

    $smtp_select_user = $database_pdo->prepare(
        'SELECT teilnehmernr, status, vorname, nachname, eMail
        FROM teilnehmer
        WHERE username = :username
        AND eMail = :email'
    );

    $smtp_select_user->execute(
        array(
            ':username' => $username,
            ':email' => $user_email
        )
    );
    $user = $smtp_select_user->fetch();

    if ($user) {
        $str_password_chars ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str_password = '';
        for ($i = 0; $i < 8; $i++)
        {
          mt_srand((double)microtime()*time());
          $str_password .= $str_password_chars{rand(0, strlen($str_password_chars)-1)};
        }

        $Betreff = 'Dein neues Passwort bei ' . $_SERVER['SERVER_NAME'];
        $text =
'Hallo ' . $user['vorname'] . ',

dein neues Passwort ist: ' . $str_password . '
---
Deine Brüder

Organisationsteam
Öffentliches Zeugnisgeben ' . CONGREGATION_NAME . '

' . $_SERVER['SERVER_NAME'] . '
' . EMAIL_ADDRESS;

        $smtp_update_user_password = $database_pdo->prepare(
            'UPDATE teilnehmer
            SET pwd = :password
            WHERE username = :username
            AND eMail = :email'
        );

        $smtp_update_user_password->execute(
            array(
                ':password' => md5($str_password),
                ':username' => $username,
                ':email' => $user_email
            )
        );

        if ($smtp_update_user_password->rowCount() != 1)
          exit('Passswort konnte nicht geändert werden. Bitte wenden Sie sich an den Support!');

        SendMail($user['eMail'], $Betreff, $text);

        $mHTML .=
            '<div class="div_PWDForgot">
                <h2>Neues Passwort</h2>
                Dein neues Passwort wurde per E-Mail and dich versendet.
            </div>';
        $ShowPWDforgot = 0;
    }
}

if ($ShowPWDforgot == 1) {
    $mHTML .=
        '<div class="div_PWDForgot">
        <h2>Passwort vergessen</h2>';
  
    if ($user === FALSE)
        $mHTML .= '<font color=red>Der Benutzername und die E-Mail Adresse wurde im System nicht gefunden!</font><br>';
  
    $mHTML .=
        'Bitte trag dein Benutzername und deine E-Mail-Adresse ein<br><br>
        <form action="index.php?Type=PWDRequest" method="post">
            <table border=0>
                <tr>
                    <td>Benutzername:</td>
                    <td><input type="Text" size="27" name="PWDLoginname"></td>
                </tr>
                <tr>
                    <td>eMail-Adresse:</td>
                    <td><input type="Text" size="27" name="PWDMail"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="Submit" value="neues Passwort anfordern"></td>
                </tr>
                    <td></td>
            </table>
        </form>
    </div>';
}
?>
