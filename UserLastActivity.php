<?php
include "function.php";
$ShowList = 1;
$Error = 0;

if ($ShowList==1) {

    $search_pattern = (isset($_POST['Search'])) ? filter_var($_POST['Search'], FILTER_SANITIZE_STRING) : '';

    $mHTML .=
        '<h3>Letzte Anmeldung der Teilnehmer</h3>
        <form action="index.php?Type=Teilnehmer" method="post">
            <input type="text" name="Search" value="' . $search_pattern . '">
            <input type="submit" name="Suchen" value="Suchen">
        </form>
        <table border="0" cellspacing="0">
            <colgroup>
                <COL WIDTH=130>
                <COL WIDTH=90>
                <COL WIDTH=150>
            </colgroup>
            <tr>
                <th align="left">Name</th>
                <th align="left">Benutzername</th>
                <th align="left">letzte Anmeldung</th>
            </tr>';

    $sql_select_user_list =
        'SELECT teilnehmernr, status, vorname, nachname, username, LastLoginTime
        FROM teilnehmer ';
    $search = array();

    if (isset($_POST['Search'])) {
        $sql_select_user_list .=
            'WHERE vorname like concat("%", :search_pattern, "%")
            OR nachname like concat("%", :search_pattern, "%")
            OR email like concat("%", :search_pattern, "%")
            OR username like concat("%", :search_pattern, "%")';

        $search = array(':search_pattern' => $search_pattern);
    }

    $sql_select_user_list .= 'ORDER BY LastLoginTime DESC';

    $smtp_select_user_list = $database_pdo->prepare($sql_select_user_list);
    $smtp_select_user_list->execute($search);

    while($user = $smtp_select_user_list->fetch()) {
        $Format_Time = strtotime($user['LastLoginTime']);
        $mHTML .=
            '<tr>
                <td>' . $user['vorname'] . ' ' .$user['nachname'] . '</td>
                <td>' . $user['username'] . '</td>
                <td>' . date("d.m.Y H:i",$Format_Time) . '</td>
            </tr>';
    }
    $mHTML .= '</table>';
}
?>

