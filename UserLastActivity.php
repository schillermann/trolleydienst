<?php
include "function.php";
$ShowList=1;
$Error=0;

if ($ShowList==1) {
    $mHTML.="<h3>Letzte Anmeldung der Teilnehmer</h3>";

    $mHTML.="<form action=\"index.php?Type=Teilnehmer\" method=\"post\">";
    $mHTML.="<input type=\"text\" name=\"Search\" ";
    if (isset($_POST['Search']))
        $mHTML.=" value=\"".$_POST['Search']."\" ";

    $mHTML.=">";
    $mHTML.="<input type=\"submit\" name=\"Suchen\" value=\"Suchen\">";
    $mHTML.="</form>";

    $mHTML.="<table border=0 cellspacing=0>";
    $mHTML.="<colgroup>";
    $mHTML.="<COL WIDTH=130>";
    $mHTML.="<COL WIDTH=90>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="</colgroup>";
    $mHTML.="<tr>";
    $mHTML.="<th align=\"left\">Name</th>";
    $mHTML.="<th align=\"left\">Benutzername</th>";
    $mHTML.="<th align=\"left\">letzte Anmeldung</th>";
    $mHTML.="</tr>";

    $SQLCommand="Select teilnehmernr, status, vorname, nachname, username , LastLoginTime  ";
    $SQLCommand.="from teilnehmer ";
    if (isset($_POST['Search'])) {
        $SQLCommand.=" Where (vorname like '%".$_POST['Search']."%') or ";
        $SQLCommand.="  (nachname like '%".$_POST['Search']."%') or ";
        $SQLCommand.="  (email like '%".$_POST['Search']."%') or ";
        $SQLCommand.="  (username like '%".$_POST['Search']."%')  ";
    }

    $SQLCommand.="order by LastLoginTime DESC ";

    $SQLResult=mysql_query($SQLCommand,$verbindung);
    while($row = mysql_fetch_object($SQLResult)) {
        $Format_Time = strtotime($row->LastLoginTime);
        $mHTML.="<tr>";
        $mHTML.="<td>".$row->vorname." ".$row->nachname."</td>";
        $mHTML.="<td>".$row->username."</td>";
        $mHTML.="<td>".date("d.m.Y H:i",$Format_Time)."</td>";
        $mHTML.="</tr>";
    }
    $mHTML.="</table>";
}


?>

