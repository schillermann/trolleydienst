<?php
include "function.php";
$ShowList=1;
$Error=0;

if (isset($_POST['SaveNewClient'])) {
    $sqlcommand="Select count(*) as Anz from teilnehmer ";
    $sqlcommand.="Where (username='".$_POST['username']."')";
    $SQLResult=mysql_query($sqlcommand,$verbindung);
    $row=mysql_fetch_object($SQLResult);

    if (($row->Anz == 0) && ($_POST['username'] != "")) {
        $teilnehmernr=1;
        $sqlcommand="Select coalesce(Max(teilnehmernr),0) + 1 as teilnehmernr from teilnehmer";
        $SQLResult=mysql_query($sqlcommand,$verbindung);
        $row=mysql_fetch_object($SQLResult);

        if ($row->teilnehmernr > 0)
            $teilnehmernr = $row->teilnehmernr;

        if (isset($_POST['Dienstart']))
            if (in_array("Admin",$_POST['Dienstart']))
                $Admin=1;
            else
                $Admin=0;
        else
            $Admin=0;

        $str_password_chars ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str_password = '';

        for ($i = 0; $i < 6; $i++) {
            mt_srand((double)microtime()*time());
            $str_password .= $str_password_chars{rand(0, strlen($str_password_chars)-1)};
        }

        $InsertCommand="Insert Into teilnehmer (";
        $InsertCommand.="teilnehmernr,status,vorname,nachname,email,username,pwd,infostand,trolley,admin,Telefonnr,Handy,versammlung,sprache) ";
        $InsertCommand.="VALUES (";
        $InsertCommand.="'".$teilnehmernr."',0,'".$_POST['Vorname']."','";
        $InsertCommand.=$_POST['Nachname']."','".$_POST['eMail']."','".$_POST['username']."','".md5($str_password)."',";
        $InsertCommand.=$_POST['Infostand'].",".$_POST['Trolley'].",".$Admin.",'".$_POST['Telefonnr']."','".$_POST['Handy']."','".$_POST['versammlung']."','".$_POST['sprache']."')";

        $Betreff = 'Zugangsdaten für ' . $_SERVER['SERVER_NAME'];

        $text="Hallo ".$_POST['Vorname'].",</br></br>";
        $text .= 'willkommen bei <a href="' . $_SERVER['SERVER_NAME'] . '">' . $_SERVER['SERVER_NAME'] . '</a>.<br>';
        $text.="Hier wird das öffentliche Zeugnisgeben einfach organisiert.<br><br>";
        $text.="Deine Zugangsdaten lauten wie folgt:<br><br>";
        $text.="<table border=0><tr><td>Benutzername:</td><td>".$_POST['username']."</td></tr>";
        $text.="<tr><td>Passwort:</td><td>".$str_password."</td></tr></table>";
        $text.="<br><br>";
        $text.="Bitte ändere dein Kennwort in dem Menüpunkt Profil<br><br>";
        $text.='Bei Anregungen und Problemen kannst du gerne ein Mail an ' . EMAIL_ADDRESS . ' schreiben oder antworte einfach diese E-Mail.<br>';

        SendMail($_POST["eMail"],$Betreff,$text);

        $SQLResult=mysql_query($InsertCommand,$verbindung);
        if (!$SQLResult)
            exit('Teilnehmer konnte nicht gespeichert werden');
    } else {
        $Error==1;
    }
}

if (isset($_POST['SaveEditClient'])) {

    if (isset($_POST['Dienstart']))
        if (in_array("Admin",$_POST['Dienstart']))
            $Admin=1;
        else
            $Admin=0;
    else
        $Admin=0;

    if (count($_POST['Status']) > 0)
        if (in_array("Aktiv",$_POST['Status']))
            $Status=0;
        else
            $Status=1;
    else
          $Status=1;

    $UpdateCommand="Update teilnehmer ";
    $UpdateCommand.="set ";
    $UpdateCommand.="vorname='".$_POST['Vorname']."', ";
    $UpdateCommand.="nachname='".$_POST['Nachname']."', ";
    $UpdateCommand.="eMail='".$_POST['eMail']."', ";
    $UpdateCommand.="username='".$_POST['username']."', ";
    $UpdateCommand.="infostand=".$_POST['Infostand'].", ";
    $UpdateCommand.="trolley=".$_POST['Trolley'].", ";
    $UpdateCommand.="admin=".$Admin.", ";
    $UpdateCommand.="status=".$Status.", ";
    $UpdateCommand.="Telefonnr='".$_POST['Telefonnr']."', ";
    $UpdateCommand.="Handy='".$_POST['Handy']."', ";
    $UpdateCommand.="versammlung='".$_POST['versammlung']."', ";
    $UpdateCommand.="sprache='".$_POST['sprache']."', ";
    $UpdateCommand.="Bemerkung='".$_POST['Bemerkung']."' ";

    $UpdateCommand.="Where (teilnehmernr = '".$_GET['ID']."')";
    $SQLResult=mysql_query($UpdateCommand,$verbindung);
    if (!$SQLResult)
        exit("Teilnehmer konnte nicht gespeichert werden");
}

if (isset($_POST['NewClient'])) {
    $ShowList=0;
    $mHTML.="<h3>Neuer Teilnehmer</h3>";
    if ($Error == 1)
        $mHTML.="<font color=\"red\">Der Benutzername existiert schon</font>";

    $mHTML.="<form action=\"index.php?Type=Teilnehmer\" method=\"post\">";
    $mHTML.="<table border=0 cellspacing=0>";
    $mHTML.="<colgroup>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="</colgroup>";;
    $mHTML.="<tr>";
    $mHTML.="<td>Vorname:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Vorname\" id=\"Vorname\" size=30></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Nachname:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Nachname\" id=\"Nachname\" size=30></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>eMail:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"eMail\" size=30></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Handynr:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Handy\" size=30></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Telefonnr:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Telefonnr\" size=30></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Versammlung:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"versammlung\" value=\"Deine Versammlung\" size=30></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Sprache:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"sprache\" value=\"deutsch\" size=30></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Benutzername:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"username\" id=\"username\"  size=30></td>";
    $mHTML.="</tr>";

    $mHTML.="<tr>";
    $mHTML.="<td>Infostand:</td>";
    $mHTML.="<td>";
    $mHTML.="<select name=\"Infostand\">";
    $mHTML.="<option value=\"0\">inaktiv</option>";
    $mHTML.="<option value=\"1\" selected>aktiv</option>";
    $mHTML.="<option value=\"2\">Schulung</option>";
    $mHTML.="</select>";
    $mHTML.="</tr>";

    $mHTML.="<tr>";
    $mHTML.="<td>Trolley:</td>";
    $mHTML.="<td>";
    $mHTML.="<select name=\"Trolley\">";
    $mHTML.="<option value=\"0\">inaktiv</option>";
    $mHTML.="<option value=\"1\" selected>aktiv</option>";
    $mHTML.="<option value=\"2\">Schulung</option>";
    $mHTML.="</select>";
    $mHTML.="</tr>";

    $mHTML.="<tr>";
    $mHTML.="<td>Admin-Recht</td>";
    $mHTML.="<td>";
    $mHTML.="<input type=\"checkbox\" name=\"Dienstart[]\" Value=\"Admin\">Ja ";
    $mHTML.="</td>";
    $mHTML.="</tr>";

    $mHTML.="</table>";
    $mHTML.="<input type=\"Submit\" name=\"SaveNewClient\" value=\"Speichern\">";
    $mHTML.="</form></br>";

    $mHTML.="<script type=\"text/javascript\"> ";

    $mHTML.="$('#Nachname').focusout(function(){ ";
    $mHTML.=" var mUsername_Part1 = $('#Vorname').val(); ";
    $mHTML.=" var mUsername_Part2 = $('#Nachname').val(); ";
    $mHTML.=" var mUsername = mUsername_Part1.substring(0, 2) + mUsername_Part2.substring(0, 2); ";
    $mHTML.=" mUsername = mUsername.replace(/ä/g, \"a\"); ";
    $mHTML.=" mUsername = mUsername.replace(/ö/g, \"o\"); ";
    $mHTML.=" mUsername = mUsername.replace(/ü/g, \"u\"); ";
    $mHTML.=" mUsername = mUsername.replace(/ß/g, \"s\"); ";

    $mHTML.=" mUsername = mUsername.replace(/Ä/g, \"A\"); ";
    $mHTML.=" mUsername = mUsername.replace(/Ö/g, \"O\"); ";
    $mHTML.=" mUsername = mUsername.replace(/Ü/g, \"U\"); ";

    $mHTML.=" $('#username').val(mUsername); ";
    $mHTML.="}); ";
    $mHTML.="</script> ";
}

if (isset($_GET['ID'])) {
    $ShowList=0;
    $SQLCommand="Select teilnehmernr, status, vorname, nachname, email , username , infostand, trolley, admin,Handy,Telefonnr,versammlung,sprache,Bemerkung ";
    $SQLCommand.="from teilnehmer ";
    $SQLCommand.="Where (teilnehmernr = '".$_GET['ID']."')";

    $SQLResult=mysql_query($SQLCommand,$verbindung);
    $row = mysql_fetch_object($SQLResult);

    $mHTML.="<h3>Teilnehmer bearbeiten</h3>";
    $mHTML.="<form action=\"index.php?Type=Teilnehmer&ID=".$_GET['ID']."\" method=\"post\">";
    $mHTML.="<table border=0 cellspacing=0>";
    $mHTML.="<colgroup>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="</colgroup>";
    $mHTML.="<tr>";
    $mHTML.="<td>Teilnehmernr:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"teilnehmernr\" size=30 Value=\"".$row->teilnehmernr."\" disabled></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Vorname:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Vorname\" size=30 Value=\"".$row->vorname."\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Nachname:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Nachname\" size=30 Value=\"".$row->nachname."\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>eMail:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"eMail\" size=30 Value=\"".$row->email."\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Handynr:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Handy\" size=30 Value=\"".$row->Handy."\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Telefonnr:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Telefonnr\" size=30 Value=\"".$row->Telefonnr."\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Versammlung:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"versammlung\" size=30 Value=\"".$row->versammlung."\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Sprache:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"sprache\" size=30 Value=\"".$row->sprache."\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Benutzername:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"username\" size=30 Value=\"".$row->username."\"></td>";
    $mHTML.="</tr>";

    $mHTML.="<tr>";
    $mHTML.="<td>Aktiv:</td>";
    $mHTML.="<td>";
    $mHTML.="<input type=\"checkbox\" name=\"Status[]\" Value=\"Aktiv\" ";
    if ($row->status == 0)
        $mHTML.=" checked ";

    $mHTML.=">Ja ";
    $mHTML.="</td>";
    $mHTML.="</tr>";

    $mHTML.="<tr>";
    $mHTML.="<td>Infostand:</td>";
    $mHTML.="<td>";
    $mHTML.="<select name=\"Infostand\">";
    $mHTML.="<option value=\"0\" ";
    if ($row->infostand == 0)
        $mHTML.=" selected ";

    $mHTML.=">inaktiv</option>";
    $mHTML.="<option value=\"1\" ";
    if ($row->infostand == 1)
        $mHTML.=" selected ";

    $mHTML.=">aktiv</option>";
    $mHTML.="<option value=\"2\" ";
    if ($row->infostand == 2)
        $mHTML.=" selected ";

    $mHTML.=">Schulung</option>";
    $mHTML.="</select>";
    $mHTML.="</tr>";

    $mHTML.="<tr>";
    $mHTML.="<td>Trolley:</td>";
    $mHTML.="<td>";
    $mHTML.="<select name=\"Trolley\">";
    $mHTML.="<option value=\"0\" ";
    if ($row->trolley == 0)
        $mHTML.=" selected ";

    $mHTML.=">inaktiv</option>";
    $mHTML.="<option value=\"1\" ";
    if ($row->trolley == 1)
        $mHTML.=" selected ";

    $mHTML.=">aktiv</option>";
    $mHTML.="<option value=\"2\" ";
    if ($row->trolley == 2)
        $mHTML.=" selected ";

    $mHTML.=">Schulung</option>";
    $mHTML.="</select>";
    $mHTML.="</tr>";

    $mHTML.="<tr>";
    $mHTML.="<td>Admin-Recht</td>";
    $mHTML.="<td>";
    $mHTML.="<input type=\"checkbox\" name=\"Dienstart[]\" Value=\"Admin\" ";
    if ($row->admin == 1)
        $mHTML.=" checked ";

    $mHTML.=">Ja ";
    $mHTML.="</td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Bemerkung:</td>";
    $mHTML.="<td><textarea name=\"Bemerkung\" cols=\"50\" rows=\"10\">".$row->Bemerkung."</textarea></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";

    $mHTML.="</table>";
    $mHTML.="<input type=\"Submit\" name=\"SaveEditClient\" value=\"Speichern\">";
    $mHTML.="</form></br>";
}

if ($ShowList==1) {
    $mHTML.="<h3>Teilnehmer</h3>";
    $mHTML.="<form action=\"index.php?Type=Teilnehmer\" method=\"POST\">";
    $mHTML.="<input type=\"submit\" name=\"NewClient\" value=\"Neuer Teilnehmer\"></form>";

    $mHTML.="<form action=\"index.php?Type=Teilnehmer\" method=\"post\">";
    $mHTML.="<input type=\"text\" name=\"Search\" ";

    if (isset($_POST['Search']))
        $mHTML.=" value=\"".$_POST['Search']."\" ";

    $mHTML.=">";
    $mHTML.="<input type=\"submit\" name=\"Suchen\" value=\"Suchen\">";
    $mHTML.="</form>";
    $mHTML.="<a href=\"index.php?Type=UserLastLogin\" target=\"_blank\">Letzte Anmeldungen</a><br><br>";
    $mHTML.="<table border=0 cellspacing=0>";
    $mHTML.="<colgroup>";
    $mHTML.="<COL WIDTH=100>";
    $mHTML.="<COL WIDTH=90>";
    $mHTML.="<COL WIDTH=90>";
    $mHTML.="<COL WIDTH=90>";
    $mHTML.="<COL WIDTH=90>";
    $mHTML.="<COL WIDTH=110>";
    $mHTML.="</colgroup>";
    $mHTML.="<tr>";
    $mHTML.="<th align=\"left\">Name</th>";
    $mHTML.="<th align=\"left\">E-Mail</th>";
    $mHTML.="<th align=\"left\">Benutzername</th>";
    $mHTML.="<th align=\"left\">Aktiv</th>";
    $mHTML.="<th align=\"left\">Infostand</th>";
    $mHTML.="<th align=\"left\">Trolley</th>";
    $mHTML.="<th align=\"left\">Admin</th>";
    $mHTML.="<th></th>";
    $mHTML.="</tr>";

    $SQLCommand="Select teilnehmernr, status, vorname, nachname, email , username , infostand, trolley, admin  ";
    $SQLCommand.="from teilnehmer ";
    if (isset($_POST['Search'])) {
        $SQLCommand.=" Where (vorname like '%".$_POST['Search']."%') or ";
        $SQLCommand.="  (nachname like '%".$_POST['Search']."%') or ";
        $SQLCommand.="  (email like '%".$_POST['Search']."%') or ";
        $SQLCommand.="  (username like '%".$_POST['Search']."%')  ";
    }

    $SQLCommand.="order by teilnehmernr DESC ";
    $SQLResult=mysql_query($SQLCommand,$verbindung);
    while($row = mysql_fetch_object($SQLResult)) {
        $mHTML.="<tr>";
        $mHTML.="<td>".$row->vorname." ".$row->nachname."</td>";
        $mHTML.="<td>".$row->email."</td>";
        $mHTML.="<td>".$row->username."</td>";
        $mHTML.="<td>";
        if ($row->status == 0)
            $mHTML.="<img src=\"images/gruener_Pfeil.png\">";
        else
            $mHTML.="<img src=\"images/verbot.png\">";

        $mHTML.="</td>";
        $mHTML.="<td>";
        if ($row->infostand == 1)
            $mHTML.="<img src=\"images/gruener_Pfeil.png\">";
        else
            if ($row->infostand == 2)
                $mHTML.="Schulung";
            else
                $mHTML.="<img src=\"images/verbot.png\">";

        $mHTML.="</td>";

        $mHTML.="<td>";
        if ($row->trolley == 1)
            $mHTML.="<img src=\"images/gruener_Pfeil.png\">";
        else
            if ($row->trolley == 2)
                $mHTML.="Schulung";
            else
                $mHTML.="<img src=\"images/verbot.png\">";

        $mHTML.="</td>";

        $mHTML.="<td>";
        if ($row->admin == 1)
            $mHTML.="<img src=\"images/gruener_Pfeil.png\">";
        else
            $mHTML.="<img src=\"images/verbot.png\">";

        $mHTML.="</td>";

        $mHTML.="<td align=\"right\">";
        $mHTML.="<form action=\"index.php?Type=Teilnehmer&ID=".$row->teilnehmernr."\" method=\"POST\">";
        $mHTML.="<input type=\"submit\" name=\"EditClient\" value=\"Bearbeiten\"></form>";
        $mHTML.="</tr>";
    }
    $mHTML.="</table>";
}
?>