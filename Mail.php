<?php
$ShowMail=1;
include "function.php";
if (isset($_POST['SendMail'])) {

    $sql =
        'SELECT teilnehmernr, status, vorname, nachname, email , username , infostand, trolley, admin
  	    FROM teilnehmer
  	    WHERE status = 0';

    if ($_POST['Empfaenger'] == 1)
        $sql .= ' AND infostand = 1';

    if ($_POST['Empfaenger'] == 2)
        $sql .= ' AND trolley = 1';

    $stmt_user_list_with_status_null = $database_pdo->query($sql);

    $mText = $_POST['Text'];
    $mText = filter_var($mText, FILTER_SANITIZE_STRING);
    $mText = nl2br($mText);
    $subject = filter_var($_POST['Betreff'], FILTER_SANITIZE_STRING);

    while($receiver = $stmt_user_list_with_status_null->fetch())
        if(!empty($receiver['email']))
            SendMail($receiver['email'], $subject, $title . $mText);

    $mHTML .=
        '<h3>Mail-Versand</h3>
  	    <div class="div_Mail">
  	        Die E-Mail wurde erfolgreich versendet
  	    </div>';
    $ShowMail=0;
}

if ($ShowMail == 1) {

    $mHTML .=
        '<h3>Mail-Versand</h3>
        <div class="div_Mail">
        <form action="index.php?Type=Mail" method="post">
            <table border=0>
                <tr>
                    <td>Empfänger:</td>
                    <td>
                        <select name="Empfaenger">
                            <option value="0" selected>alle</option>
                            <option value="1">Infostand</option>
                            <option value="2">Trolley</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Betreff:</td>
                    <td><input type="text" name="Betreff" size="61"></td>
                </tr>
                <tr>
                    <td valign="top">Text:</td>
                    <td>
<textarea name="Text" cols="62" rows="20">Hallo,

DEINE_NACHRICHT

---
Deine Brüder

Trolley Team
Öffentliches Zeugnisgeben ' . CONGREGATION_NAME . '

' . $_SERVER['SERVER_NAME'] . '
' . EMAIL_REPLY_TO_ADDRESS . '</textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="SendMail" Value="senden"></td>
                </tr>
            </table>
        </form>
    </div>';
}
?>