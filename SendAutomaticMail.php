<?php
session_start();
include "DBConnect.php";
include "function.php";

echo "nicht versendete Termine werden geladen<br>";
$SQLCommand="Select terminnr,art,ort,termin_von,termin_bis ";
$SQLCommand.="from termine  ";
$SQLCommand.="Where (coalesce(sendedmail,0)=0) ";
$SQLResult=mysql_query($SQLCommand,$verbindung);
$Trolley=0;
$Info=0;
$SendMail=0;
echo "nicht versendete Termine wurde geladen<br>";
while($row = mysql_fetch_object($SQLResult)) {
    $SendMail = 1;
    if ($row->art == 0)
        $Info=1;
    else
        $Trolley=1;
}
  
if ($SendMail == 1) {
    echo "Teilnehmerliste wird geladen<br>";
    $SQLCommandUser="Select teilnehmernr, status, vorname, nachname, email , username , infostand, trolley, admin  ";
    $SQLCommandUser.="from teilnehmer ";
    $SQLCommandUser.="Where (status=0)  ";
    if ($Info == 1)
        $SQLCommandUser.=" and (infostand=1) ";

    if ($Trolley == 1)
        $SQLCommandUser.=" and (trolley=1) ";

    $SQLResultUser=mysql_query($SQLCommandUser,$verbindung);
    echo "Teilnehmerliste wurde geladen<br>";
    while($rowUser = mysql_fetch_object($SQLResultUser)) {
        $Body='Hallo '.$rowUser->vorname.', <br><br>';
        $Body.='es wurden neue Termine für das öffentliche Zeugnisgeben freigegeben.<br>';
        $Body.='Bewirb dich jetzt, auf <a href="' . $_SERVER['SERVER_NAME'] . '">' . $_SERVER['SERVER_NAME'] . '</a>!';
        SendMail($rowUser->email,'Neue Termine',$Body);
    }

    echo "E-Mails wurden geladen<br>";
    $UpdateCommand="Update termine  ";
    $UpdateCommand.="set ";
    $UpdateCommand.="sendedmail =1 ";

    $SQLResult=mysql_query($UpdateCommand,$verbindung);
}
  
  
echo "nicht versendete Schichten werden geladen<br>";
$SQLCommand="Select coalesce(SchTeil.isschichtleiter,0) as isschichtleiter,SchTeil.teilnehmernr, ";
$SQLCommand.="DATE_FORMAT(termin_von, '%d.%m.%Y') as mDatum, ";
$SQLCommand.="DATE_FORMAT(termin_von, '%w') as mWochentag, ";
$SQLCommand.="DATE_FORMAT(Sch.von, '%H:%i') as mVon, ";
$SQLCommand.="DATE_FORMAT(Sch.bis, '%H:%i') as mBis ";

$SQLCommand.="from schichten_teilnehmer SchTeil inner join schichten Sch  ";
$SQLCommand.="on ((SchTeil.terminnr = Sch.terminnr) and ";
$SQLCommand.=" (SchTeil.schichtnr = Sch.Schichtnr)) ";
$SQLCommand.=" inner join termine Ter ";
$SQLCommand.=" on Sch.terminnr = Ter.terminnr ";
$SQLCommand.="Where (coalesce(SchTeil.sendedmail,0)=0) and (SchTeil.status=2) ";

$SQLResult=mysql_query($SQLCommand,$verbindung);
$Trolley=0;
$Info=0;
$SendMail=0;
$mSchichten = array();
echo "nicht versendete Schichten geladen<br>";

while($row = mysql_fetch_object($SQLResult)) {
    $mSchicht= [$row->teilnehmernr,$row->isschichtleiter,$row->mDatum,$row->mVon,$row->mBis,$row->mWochentag];
    $mSchichten[] = $mSchicht;
}
echo "Mailiste wird geladen<br>";
echo "Teilnehmerliste wird geladen<br>";
$SQLCommandUser="Select teilnehmernr, status, vorname, nachname, email , username , infostand, trolley, admin  ";
$SQLCommandUser.="from teilnehmer ";
$SQLCommandUser.="Where (status=0)  ";
$SQLResultUser=mysql_query($SQLCommandUser,$verbindung);
echo "Teilnehmerliste wurde geladen<br>";

while($rowUser = mysql_fetch_object($SQLResultUser)) {
    $mBody="";
    foreach ($mSchichten as $aSchicht)
    {
        if ($aSchicht[0] == $rowUser->teilnehmernr)
        {
            //Freitag, 12.12.2014, 09:00 bis 11:00 Uhr
            $mBody.= "<br><b>".Get_Wochentag($aSchicht[5]).", ".$aSchicht[2].', '.$aSchicht[3]." bis ".$aSchicht[4]."</b><br>";
            if ($aSchicht[1] == '1')
                $mBody.="<b>Du bist gleichzeitig Schichtleiter.</b><br>";
        }
    }
    if ($mBody != "")
    {
        $Mail='Hallo '.$rowUser->vorname.', <br><br>';
        $Mail.= 'folgende Schicht(en) wurde(n) bestätigt:<br>'.$mBody.'<br>';
        $Mail.='Weitere Informationen kannst du unter <a href="' . $_SERVER['SERVER_NAME'] . '">' . $_SERVER['SERVER_NAME'] . '</a> ersehen.';
        sendmail($rowUser->email,'Neue Schicht',$Mail);
        echo "Mail versendet<br>";
    }
}

$UpdateCommand="Update schichten_teilnehmer  ";
$UpdateCommand.="set ";
$UpdateCommand.="sendedmail =1 ";
$UpdateCommand.="Where (status=2) ";

$SQLResult=mysql_query($UpdateCommand,$verbindung);
?>