<?php
include "function.php";
$ShowList = 1;
$Error = 0;

if (isset($_POST['SaveNewClient'])) {

    $smtp_number_of_user = $database_pdo->prepare(
        'SELECT count(*) AS Anz
        FROM teilnehmer
        WHERE (username= :username'
    );

    $smtp_number_of_user->execute(
        array(':username' => $_POST['username'])
    );

    $number_of_user = $smtp_number_of_user->fetch();

    if (($number_of_user['Anz'] == 0) && ($_POST['username'] != '')) {

        $smtp_next_id_user = $database_pdo->query(
            'SELECT coalesce(Max(teilnehmernr), 0) + 1 AS teilnehmernr 
            FROM teilnehmer'
        );

        $next_id_user = $smtp_next_id_user->fetch();

        $teilnehmernr = ($next_id_user['teilnehmernr'] == 0) ? 1 : (int)$next_id_user['teilnehmernr'];

        $Admin = 0;
        if (isset($_POST['Dienstart']) && in_array("Admin", $_POST['Dienstart']))
            $Admin = 1;

        $str_password_chars ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str_password = '';

        for ($i = 0; $i < 6; $i++) {
            mt_srand((double)microtime()*time());
            $str_password .= $str_password_chars{rand(0, strlen($str_password_chars) - 1)};
        }

        $smtp_insert_user = $database_pdo->prepare(
            'INSERT INTO teilnehmer
            (
              teilnehmernr, status, vorname, nachname, email, username, pwd,
              infostand, trolley, admin, Telefonnr, Handy, versammlung, sprache
            )
            VALUES
            (
              :id_user, 0, :firstname, :surname, :email, :username, :password,
              :literature_table, :literature_cart, :is_admin, :phone, :mobile, :congregation, :language
            )'
        );

        $smtp_insert_user->execute(
            array(
                ':id_user' => (int)$teilnehmernr,
                ':firstname' => filter_var($_POST['Vorname'], FILTER_SANITIZE_STRING),
                ':surname' => filter_var($_POST['Nachname'], FILTER_SANITIZE_STRING),
                ':email' => (string)filter_var($_POST['eMail'], FILTER_VALIDATE_EMAIL),
                ':username' => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
                ':password' => md5($str_password),
                ':literature_table' => (int)$_POST['Infostand'],
                ':literature_cart' => (int)$_POST['Trolley'],
                ':is_admin' => (int)$Admin,
                ':phone' => filter_var($_POST['Telefonnr'], FILTER_SANITIZE_NUMBER_INT),
                ':mobile' => filter_var($_POST['Handy'], FILTER_SANITIZE_NUMBER_INT),
                ':congregation' => filter_var($_POST['versammlung'], FILTER_SANITIZE_STRING),
                ':language' => filter_var($_POST['sprache'], FILTER_SANITIZE_STRING)
            )
        );

        if ($smtp_insert_user->rowCount() != 1)
            exit('Teilnehmer konnte nicht gespeichert werden');

        $firstname = htmlspecialchars($_POST['Vorname']);
        $username = htmlspecialchars($_POST['username']);
        $Betreff = 'Zugangsdaten für ' . $_SERVER['SERVER_NAME'];

        $text =
            'Hallo ' . $firstname . ',</br></br>
            willkommen bei <a href="' . $_SERVER['SERVER_NAME'] . '">' . $_SERVER['SERVER_NAME'] . '</a>.<br>
            Hier wird das öffentliche Zeugnisgeben einfach organisiert.<br><br>
            Deine Zugangsdaten lauten wie folgt:<br><br>
            <table border=0>
                <tr>
                    <td>Benutzername:</td>
                    <td>' . $username .'</td>
                </tr>
                <tr>
                    <td>Passwort:</td>
                    <td>' . $str_password . '</td>
                </tr>
            </table>
            <br><br>
            Bitte ändere dein Kennwort in dem Menüpunkt Profil<br><br>
            Bei Anregungen und Problemen kannst du gerne ein Mail an ' . EMAIL_REPLY_TO_ADDRESS . ' schreiben oder antworte einfach diese E-Mail.<br>';

        SendMail($_POST["eMail"], $Betreff, $text);

    } else {
        $Error==1;
    }
}

if (isset($_POST['SaveEditClient'])) {

    if (isset($_POST['Dienstart']) && in_array("Admin", $_POST['Dienstart']))
        $Admin = 1;
    else
        $Admin = 0;

    if (count($_POST['Status']) > 0 && in_array("Aktiv",$_POST['Status']))
        $Status = 0;
    else
        $Status = 1;

    $smtp_update_user = $database_pdo->prepare(
        'UPDATE teilnehmer
        SET vorname = :firstname,
        nachname = :surname,
        eMail = :email,
        username = :username,
        infostand = :literature_table,
        trolley = :literature_cart,
        admin = :is_admin,
        status = :status,
        Telefonnr = :phone,
        Handy = :mobile,
        versammlung = :congregation,
        sprache = :language,
        Bemerkung = :note_admin
        WHERE teilnehmernr = :id_user'
    );

    $smtp_update_user->execute(
        array(
            ':firstname' => filter_var($_POST['Vorname'], FILTER_SANITIZE_STRING),
            ':surname' => filter_var($_POST['Nachname'], FILTER_SANITIZE_STRING),
            ':email' => (string)filter_var($_POST['eMail'], FILTER_VALIDATE_EMAIL),
            ':username' => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
            ':literature_table' => (int)$_POST['Infostand'],
            ':literature_cart' => (int)$_POST['Trolley'],
            ':is_admin' => (int)$Admin,
            ':status' => (int)$Status,
            ':phone' => filter_var($_POST['Telefonnr'], FILTER_SANITIZE_NUMBER_INT),
            ':mobile' => filter_var($_POST['Handy'], FILTER_SANITIZE_NUMBER_INT),
            ':congregation' => filter_var($_POST['versammlung'], FILTER_SANITIZE_STRING),
            ':language' => filter_var($_POST['sprache'], FILTER_SANITIZE_STRING),
            ':note_admin' => filter_var($_POST['Bemerkung'], FILTER_SANITIZE_STRING),
            ':id_user' => (int)$_GET['ID']
        )
    );

    if ($smtp_update_user->rowCount() != 1)
        exit('Teilnehmer konnte nicht gespeichert werden!');
}

if (isset($_POST['NewClient'])) {
    $ShowList=0;
    $error_message = ($Error == 1) ? '<font color="red">Der Benutzername existiert schon</font>' : '';

    $mHTML .=
        '<h3>Neuer Teilnehmer</h3>' . $error_message . '
        <form action="index.php?Type=Teilnehmer" method="post">
            <table border=0 cellspacing=0>
                <colgroup>
                    <COL WIDTH=150>
                    <COL WIDTH=150>
                </colgroup>
                <tr>
                    <td>Vorname:</td>
                    <td><input type="Text" name="Vorname" id="Vorname" size="30"></td>
                </tr>
                <tr>
                    <td>Nachname:</td>
                    <td><input type="Text" name="Nachname" id="Nachname" size="30"></td>
                </tr>
                <tr>
                    <td>E-Mail:</td>
                    <td><input type="Text" name="eMail" size="30"></td>
                </tr>
                <tr>
                    <td>Handynr:</td>
                    <td><input type="Text" name="Handy" size="30"></td>
                </tr>
                <tr>
                    <td>Telefonnr:</td>
                    <td><input type="Text" name="Telefonnr" size="30"></td>
                </tr>
                <tr>
                    <td>Versammlung:</td>
                    <td><input type="Text" name="versammlung" value="' . CONGREGATION_NAME . '" size="30"></td>
                </tr>
                <tr>
                    <td>Sprache:</td>
                    <td><input type="Text" name="sprache" value="deutsch" size="30"></td>
                </tr>
                <tr>
                    <td>Benutzername:</td>
                    <td><input type="Text" name="username" id="username"  size="30"></td>
                </tr>
                <tr>
                    <td>Infostand:</td>
                    <td>
                        <select name="Infostand">
                            <option value="0">inaktiv</option>
                            <option value="1" selected>aktiv</option>
                            <option value="2">Schulung</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Trolley:</td>
                    <td>
                        <select name="Trolley">
                            <option value="0">inaktiv</option>
                            <option value="1" selected>aktiv</option>
                            <option value="2">Schulung</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Admin-Recht</td>
                    <td>
                        <input type="checkbox" name="Dienstart[]" Value="Admin">Ja
                    </td>
                </tr>
            </table>
            <input type="Submit" name="SaveNewClient" value="Speichern">
        </form></br>
        <script type="text/javascript">
            $("#Nachname").focusout(function(){
                var mUsername_Part1 = $("#Vorname").val();
                var mUsername_Part2 = $("#Nachname").val();
                var mUsername = mUsername_Part1.substring(0, 2) + mUsername_Part2.substring(0, 2);
                mUsername = mUsername.replace(/ä/g, "a");
                mUsername = mUsername.replace(/ö/g, "o");
                mUsername = mUsername.replace(/ü/g, "u");
                mUsername = mUsername.replace(/ß/g, "s");
                mUsername = mUsername.replace(/Ä/g, "A");
                mUsername = mUsername.replace(/Ö/g, "O");
                mUsername = mUsername.replace(/Ü/g, "U");
                $("#username").val(mUsername);
            });
        </script>';
}

if (isset($_GET['ID'])) {
    $ShowList = 0;

    $smtp_select_user = $database_pdo->prepare(
        'SELECT teilnehmernr, status, vorname, nachname, email, username, infostand,
        trolley, admin, Handy, Telefonnr, versammlung, sprache, Bemerkung
        FROM teilnehmer
        WHERE teilnehmernr = :id_user'
    );

    $smtp_select_user->execute(
        array(':id_user' => (int)$_GET['ID'])
    );

    $user = $smtp_select_user->fetch();

    $check_status = ($user['status'] == 0) ? 'checked' : '';

    $check_literature_table_0 = ($user['infostand'] == 0) ? 'selected' : '';
    $check_literature_table_1 = ($user['infostand'] == 1) ? 'selected' : '';
    $check_literature_table_2 = ($user['infostand'] == 2) ? 'selected' : '';

    $check_literature_cart_0 = ($user['trolley'] == 0) ? 'selected' : '';
    $check_literature_cart_1 = ($user['trolley'] == 1) ? 'selected' : '';
    $check_literature_cart_2 = ($user['trolley'] == 2) ? 'selected' : '';

    $check_admin = ($user['admin'] == 1) ? 'checked' : '';

    $mHTML .=
        '<h3>Teilnehmer bearbeiten</h3>
        <form action="index.php?Type=Teilnehmer&ID=' . (int)$_GET['ID'] . '" method="post">
            <table border="0" cellspacing="0">
                <colgroup>
                    <COL WIDTH=150>
                    <COL WIDTH=150>
                </colgroup>
                <tr>
                    <td>Teilnehmernr:</td>
                    <td><input type="Text" name="teilnehmernr" size="30" value="' . $user['teilnehmernr'] . '" disabled></td>
                </tr>
                <tr>
                    <td>Vorname:</td>
                    <td><input type="Text" name="Vorname" size="30" value="' . $user['vorname'] . '"></td>
                </tr>
                <tr>
                    <td>Nachname:</td>
                    <td><input type="Text" name="Nachname" size="30" value="' . $user['nachname'] . '"></td>
                </tr>
                <tr>
                    <td>eMail:</td>
                    <td><input type="Text" name="eMail" size="30" value="' . $user['email'] . '"></td>
                </tr>
                <tr>
                    <td>Handynr:</td>
                    <td><input type="Text" name="Handy" size="30" value="' . $user['Handy'] . '"></td>
                </tr>
                <tr>
                    <td>Telefonnr:</td>
                    <td><input type="Text" name="Telefonnr" size="30" value="' .$user['Telefonnr'] . '"></td>
                </tr>
                <tr>
                    <td>Versammlung:</td>
                    <td><input type="Text" name="versammlung" size="30" value="' . $user['versammlung'] . '"></td>
                </tr>
                <tr>
                    <td>Sprache:</td>
                    <td><input type="Text" name="sprache" size="30" value="' . $user['sprache'] . '"></td>
                </tr>
                <tr>
                    <td>Benutzername:</td>
                    <td><input type="Text" name="username" size="30" value="' . $user['username'] . '"></td>
                </tr>
                <tr>
                    <td>Aktiv:</td>
                    <td>
                    <input type="checkbox" name="Status[]" value="Aktiv" ' . $check_status . '>Ja</td>
                </tr>
                <tr>
                    <td>Infostand:</td>
                    <td>
                        <select name="Infostand">
                            <option value="0" '. $check_literature_table_0 .'>inaktiv</option>
                            <option value="1" ' . $check_literature_table_1 . '>aktiv</option>
                            <option value="2" ' . $check_literature_table_2 . '>Schulung</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Trolley:</td>
                    <td>
                        <select name="Trolley">
                            <option value="0" '. $check_literature_cart_0 .'>inaktiv</option>
                            <option value="1" ' . $check_literature_cart_1 . '>aktiv</option>
                            <option value="2" ' . $check_literature_cart_2 . '>Schulung</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Admin-Recht</td>
                    <td>
                        <input type="checkbox" name="Dienstart[]" value="Admin" ' . $check_admin . '>Ja
                    </td>
                </tr>
                <tr>
                    <td>Bemerkung:</td>
                    <td>
                        <textarea name="Bemerkung" cols="50" rows="10">' . $user['Bemerkung'] . '</textarea>
                    </td>
                </tr>
            </table>
            <input type="Submit" name="SaveEditClient" value="Speichern">
        </form></br>';
}

if ($ShowList == 1) {

    $search_string = (isset($_POST['Search'])) ? filter_var($_POST['Search'], FILTER_SANITIZE_STRING) : '';

    $mHTML .=
        '<h3>Teilnehmer</h3>
        <form action="index.php?Type=Teilnehmer" method="POST">
            <input type="submit" name="NewClient" value="Neuer Teilnehmer">
        </form>
        <form action="index.php?Type=Teilnehmer" method="post">
            <input type="text" name="Search" value="' . $search_string . '">
            <input type="submit" name="Suchen" value="Suchen">
        </form>
        <a href="index.php?Type=UserLastLogin" target="_blank">Letzte Anmeldungen</a><br><br>
        <table border=0 cellspacing=0>
            <colgroup>
                <COL WIDTH=100>
                <COL WIDTH=90>
                <COL WIDTH=90>
                <COL WIDTH=90>
                <COL WIDTH=90>
                <COL WIDTH=110>
            </colgroup>
            <tr>
                <th align="left">Name</th>
                <th align="left">E-Mail</th>
                <th align="left">Benutzername</th>
                <th align="left">Aktiv</th>
                <th align="left">Infostand</th>
                <th align="left">Trolley</th>
                <th align="left">Admin</th>
                <th></th>
            </tr>';



    $sql_select_user =
        'SELECT teilnehmernr, status, vorname, nachname, email, username, infostand, trolley, admin  
        FROM teilnehmer ';

    $search_pattern = array();

    if (isset($_POST['Search'])) {
        $sql_select_user .=
            'WHERE vorname like concat("%", :search_pattern, "%")
            OR nachname like concat("%", :search_pattern, "%")
            OR email like concat("%", :search_pattern, "%")
            OR username like concat("%", :search_pattern, "%")';

        $search_pattern = array(':search_pattern' => $search_string);
    }

    $sql_select_user .= 'ORDER BY teilnehmernr DESC';

    $smtp_select_user = $database_pdo->prepare($sql_select_user);
    $smtp_select_user->execute($search_pattern);

    while($user = $smtp_select_user->fetch()) {
        $mHTML .=
            '<tr>
                <td>' . $user['vorname'] . ' ' . $user['nachname'] . '</td>
                <td>' . $user['email'] . '</td>
                <td>' . $user['username'] . '</td>
                <td>';
        if ($user['status'] == 0)
            $mHTML .= '<img src="images/gruener_Pfeil.png">';
        else
            $mHTML .= '<img src="images/verbot.png">';

        $mHTML .= '</td><td>';
        if ($user['infostand'] == 1)
            $mHTML .= '<img src="images/gruener_Pfeil.png">';
        else
            if ($user['infostand'] == 2)
                $mHTML .= 'Schulung';
            else
                $mHTML .= '<img src="images/verbot.png">';

        $mHTML .= '</td><td>';
        if ($user['trolley'] == 1)
            $mHTML .= '<img src="images/gruener_Pfeil.png">';
        else
            if ($user['trolley'] == 2)
                $mHTML .= 'Schulung';
            else
                $mHTML .= '<img src="images/verbot.png">';

        $mHTML .= '</td><td>';
        if ($user['admin'] == 1)
            $mHTML .= '<img src="images/gruener_Pfeil.png">';
        else
            $mHTML .= '<img src="images/verbot.png">';

        $mHTML .=
            '</td>
            <td align="right">
                <form action="index.php?Type=Teilnehmer&ID=' .$user['teilnehmernr'] . '" method="POST">
                    <input type="submit" name="EditClient" value="Bearbeiten">
                </form>
            </td>
        </tr>';
    }
    $mHTML .= '</table>';
}
?>