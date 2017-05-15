<?php
session_start();
define('TROLLEYDIENST_VERSION', '1.2.3');
require 'config.php';
require 'DBConnect.php';

spl_autoload_register();

$database_pdo = connect_to_database(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);

if (isset($_GET['Logout']))
    $_SESSION = array();

$LoginError = 0;
if (isset($_POST['Setlogin'])) {

    $stmt_user_login = $database_pdo->prepare(
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
        $_SESSION['ID'] = $user['teilnehmernr'];
        $_SESSION['Name'] = $user['vorname'] . ' ' . $user['nachname'];
        $_SESSION['eMail'] = $user['email'];
        $_SESSION['infostand'] = ($user['literature_table'] == 0) ? 0 : 1;
        $_SESSION['trolley'] = ($user['literature_cart'] == 0) ? 0 : 1;
        $_SESSION['admin'] = (int)$user['admin'];

        $stmt_user_last_login = $database_pdo->prepare(
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

        header('location: index.php?Type=Schichten');
    }
    else
    {
        $LoginError=1;
    }
}

$message_welcome = '';
$version = '';

if (isset($_SESSION['ID'])) {
    $version = 'Version ' . TROLLEYDIENST_VERSION;
    $message_welcome = 'Willkommen ' . $_SESSION['Name'] . ' - <a href="index.php?Logout=Logout">Abmelden</a>';
}

$admin_nav = '';

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    $admin_nav =
        '<li><a href="index.php?Type=Teilnehmer">Teilnehmer</a></li>
        <li><a href="index.php?Type=Termine">Termine</a></li>
        <li><a href="index.php?Type=Mail">E-Mail</a></li>';
}

$mHTML =
    '<html>
        <header>
            <title>Schichtplanung</title>
            <meta charset="utf-8"/>
            <link rel="stylesheet" type="text/css" href="css/main.css">
            <script src="jquery.min.js"></script>
        </header>
        <body>
            <div class="div_page">
                <div class="div_logo"><img src="images/Logo.png" style="max-height:120px;"></div>
                <div class="div_HeaderRight">
                    <div class="div_HeaderTitleleft"></div>
                    <div class="div_HeaderTitleright">' . $message_welcome . '</div>
                </div>
                <div class="Div_Clear"></div>
                <div class="div_Menu">
                    <ul>
                        <li><a href="index.php?Type=Schichten">Schichten</a></li>
                        <li><a href="index.php?Type=Infos">News</a></li>
                        <li><a href="index.php?Type=Profil">Profil</a></li>
                        ' . $admin_nav . '
                    </ul>
                </div>
                <div class="div_MainTypePage">';

if (isset($_SESSION['ID'])) {
    if (isset($_GET['Type'])) {

        if ($_GET['Type'] == 'Schichten')
            include "Schichten.php";

        if ($_GET['Type'] == 'Infos')
            include "News.php";

        if ($_GET['Type'] == 'Profil')
            include "Profil.php";

        if ($_GET['Type'] == 'Teilnehmer')
            include "user.php";

        if ($_GET['Type'] == 'Termine')
            include "Termine.php";

        if ($_GET['Type'] == 'Mail')
            include "Mail.php";

        if ($_GET['Type'] == 'UserLastLogin')
            include "UserLastActivity.php";
    } else {
        include "Schichten.php";
    }
} else {
    $ShowLogin=1;
    if (isset($_GET['Type'])) {
        if ($_GET['Type'] == 'PWDRequest') {
            include "PWDforgot.php";
            $ShowLogin=0;
        }
    }

    if ($ShowLogin == 1) {
        $mHTML.="<div class=\"div_Anmeldung\">";

        if ($LoginError == 1)
            $mHTML.="<font color=\"#FF0000\">Anmeldung fehlgeschlagen</font>";

        $mHTML.="<form action=\"index.php\" method=\"post\">";
        $mHTML.="<table border=0>";

        $mHTML.="<tr>";
        $mHTML.="<td>Benutzername</td>";
        $mHTML.="<td><input type=\"text\" name=\"login_name\"></td>";
        $mHTML.="</tr>";

        $mHTML.="<tr>";
        $mHTML.="<td>Passwort:</td>";
        $mHTML.="<td><input type=\"password\" name=\"login_PWD\"></td>";
        $mHTML.="</tr>";

        $mHTML.="<tr>";
        $mHTML.="<td></td>";
        $mHTML.="<td><input type=\"submit\" name=\"Setlogin\" Value=\"Anmelden\"></td>";
        $mHTML.="</tr>";

        $mHTML.="<tr>";
        $mHTML.="<td></td>";
        $mHTML.="<td><a href=\"index.php?Type=PWDRequest\">Passwort vergessen</a></td>";
        $mHTML.="</tr>";

        $mHTML.="</table>";
        $mHTML.="</form>";
        $mHTML.="</div>";
    }
}
$mHTML .=
    '            </div>
            </div>
        </body>
    </html>';

echo $mHTML;
?>