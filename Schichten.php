<?php
$ShowList=1;
include "function.php";

if (isset($_POST['DelSchichtTeil']))
{
    $SQLCommandSchichten="Select sch.terminnr, sch.von, sch.bis, sch.Schichtnr, ";
    $SQLCommandSchichten.="DATE_FORMAT(sch.von, '%d.%m.%Y') as mDatum, ";
    $SQLCommandSchichten.="DATE_FORMAT(sch.von, '%H:%i') as Zeitvon, ";
    $SQLCommandSchichten.="DATE_FORMAT(sch.bis, '%H:%i') as Zeitbis, ";
    $SQLCommandSchichten.="coalesce(mUser.vorname,'') as vorname, ";
    $SQLCommandSchichten.="coalesce(mUser.nachname,'') as nachname ";

    $SQLCommandSchichten.="from schichten sch inner join schichten_teilnehmer mTeil  ";
    $SQLCommandSchichten.=" on sch.terminnr = mTeil.terminnr  and ";
    $SQLCommandSchichten.=" sch.Schichtnr = mTeil.Schichtnr ";
    $SQLCommandSchichten.=" inner join teilnehmer mUser ";
    $SQLCommandSchichten.=" on mTeil.teilnehmernr = mUser.teilnehmernr   ";
    $SQLCommandSchichten.="Where (sch.terminnr=".$_POST['Terminnr'].") and ";
    $SQLCommandSchichten.="(sch.Schichtnr = ".$_POST['Schichtnr'].") and ";
    $SQLCommandSchichten.="(mTeil.teilnehmernr = ".$_SESSION['ID'].") and  ";
    $SQLCommandSchichten.="(mTeil.status = 2)  ";
    $SQLCommandSchichten.="order by sch.Schichtnr ";

    $SQLResultSchichten=mysql_query($SQLCommandSchichten,$verbindung);


    while($row = mysql_fetch_object($SQLResultSchichten)) {
        $mMessage="Liebes ÖZ-Organisationsteam, <br><br>";
        $mMessage.="folgende Schicht wurde zurückgewiesen: <br>";
        $mMessage.="Datum: ".$row->mDatum." ".$row->Zeitvon."-".$row->Zeitbis."<br>";
        $mMessage.="Von: ".$row->vorname." ".$row->nachname."<br>";
        SendMail(EMAIL_ADDRESS,'Schicht zurückgewiesen',$mMessage);

    }

    $DeleteCommand="Delete from schichten_teilnehmer ";
    $DeleteCommand.="Where (terminnr = ".$_POST['Terminnr'].") and ";
    $DeleteCommand.="(Schichtnr = ".$_POST['Schichtnr'].") and ";
    $DeleteCommand.="(teilnehmernr = ".$_SESSION['ID'].") ";

    $SQLResult=mysql_query($DeleteCommand,$verbindung);
}

if (isset($_GET['SubType']))
{
    if ($_GET['SubType'] == 'DelUser')
    {
        $ShowList = 0;

        $SQLCommandSchichten="Select sch.terminnr, sch.von, sch.bis, sch.Schichtnr, ";
        $SQLCommandSchichten.="DATE_FORMAT(sch.von, '%d.%m.%Y') as mDatum, ";
        $SQLCommandSchichten.="DATE_FORMAT(sch.von, '%H:%i') as Zeitvon, ";
        $SQLCommandSchichten.="DATE_FORMAT(sch.bis, '%H:%i') as Zeitbis ";
        $SQLCommandSchichten.="from schichten sch  ";
        $SQLCommandSchichten.="Where (sch.terminnr=".$_GET['Terminnr'].") and ";
        $SQLCommandSchichten.="(sch.Schichtnr = ".$_GET['Schichtnr'].") ";
        $SQLCommandSchichten.="order by sch.Schichtnr ";
        $SQLResultSchichten=mysql_query($SQLCommandSchichten,$verbindung);
        $row = mysql_fetch_object($SQLResultSchichten);

        $mHTML.="<div class=\"div_Warning\">";
        $mHTML.="<form action=\"index.php?Type=Schichten\" method=\"post\">";
        $mHTML.="Möchtest du die Schicht am ".$row->mDatum." vom ".$row->Zeitvon." bis ".$row->Zeitbis." zurückweisen?</br></br>";
        $mHTML.=" <input type=\"hidden\" name=\"Terminnr\" Value=\"".$_GET['Terminnr']."\"> ";
        $mHTML.=" <input type=\"hidden\" name=\"Schichtnr\" Value=\"".$_GET['Schichtnr']."\"> ";
        $mHTML.=" <input type=\"submit\" name=\"DelSchichtTeil\" Value=\"Ja\"> ";
        $mHTML.=" <input type=\"submit\" name=\"GoBack\" Value=\"Nein\">";
        $mHTML.="</form>";
        $mHTML.="</div>";
    }
}

if (isset($_POST['SetSchicht']))
{
    $InsertSchichtTeil="INSERT INTO schichten_teilnehmer ";
    $InsertSchichtTeil.="(terminnr, schichtnr, teilnehmernr, status, isschichtleiter) ";
    $InsertSchichtTeil.="VALUES (";
    $InsertSchichtTeil.=$_POST['Terminnr'].",".$_POST['Schichtnr'].",".$_SESSION['ID'].",0,0)";
    $SQLResult=mysql_query($InsertSchichtTeil,$verbindung);
}

if ($ShowList == 1)
{
    $SQLCommand="Select FilterTerminTage from settings ";
    $SQLResult=mysql_query($SQLCommand,$verbindung);
    $row = mysql_fetch_object($SQLResult);
    $mTageFilter = $row->FilterTerminTage;

    $mHTML.="<h3 class=\"Title_Middle\">Schichten</h3>";
    $mHTML.="<div class=\"div_Legende\">";
    $mHTML.="<table>";
    $mHTML.="<colgroup>";
    $mHTML.="<COL WIDTH=60>";
    $mHTML.="<COL WIDTH=20>";
    $mHTML.="<COL WIDTH=60>";
    $mHTML.="<COL WIDTH=20>";
    $mHTML.="<COL WIDTH=60>";
    $mHTML.="<COL WIDTH=20>";
    $mHTML.="<COL WIDTH=60>";
    $mHTML.="</colgroup>";
    $mHTML.="<tr>";
    $mHTML.="<td class=\"Legende\">Legende:</td>";
    $mHTML.="<td class=\"Teilnehmer_Status0_Legende\">??</td>";
    $mHTML.="<td class=\"Legende\">beworben</td>";
    $mHTML.="<td class=\"Teilnehmer_Status2_Legende\"></td>";
    $mHTML.="<td class=\"Legende\">bestätigt</td>";
    $mHTML.="<td class=\"Teilnehmer_Schichtleiter_Legende\">SL</td>";
    $mHTML.="<td class=\"Legende\">Schichtleiter</td>";
    $mHTML.="</tr>";
    $mHTML.="</table>";
    $mHTML.="</div>";

    $AllowSchichtArt="-1";
    if ($_SESSION['infostand'] == 1)
        $AllowSchichtArt.=",0";
    if ($_SESSION['trolley'] == 1)
        $AllowSchichtArt.=",1";

    $SQLCommand="Select terminnr , art , ort , ";
    $SQLCommand.="DATE_FORMAT(termin_von, '%d.%m.%Y') as mDatum, ";
    $SQLCommand.="DATE_FORMAT(termin_von, '%w') as mWochentag, ";
    $SQLCommand.="DATE_FORMAT(termin_von, '%H:%i') as mVon, ";
    $SQLCommand.="DATE_FORMAT(termin_bis, '%H:%i') as mBis, ";
    $SQLCommand.="DATEDIFF(termin_von,curdate()) AS DiffDate, ";
    $SQLCommand.="coalesce(sonderschicht,0) as sonderschicht ";
    $SQLCommand.="from termine  ";
    $SQLCommand.="Where (art in (".$AllowSchichtArt.")) and  ";
    $SQLCommand.="  (datediff(curdate(),termin_von) <= ".$mTageFilter." ) ";
    $SQLCommand.="order by termin_von ASC ";

    $SQLResult=mysql_query($SQLCommand,$verbindung);
    while($row = mysql_fetch_object($SQLResult)) {
        $zusText="";
        if ($row->sonderschicht) {
            $Farbe='#D99694';
            $zusText="Sonderschicht ";
        } else {
            if ($row->art == 0) {
                $Farbe='#FFC000';
            } else {
                $Farbe='#8B72AA';
                $Farbe='#B3A2C7';
            }
        }

        $mHTML.="<div class=\"div_Schicht\" style=\"background-color:".$Farbe.";\">";
        $mHTML.="<div class=\"div_Schicht_Header\">";
        $mHTML.="<div class=\"div_Schicht_Header_left\">";
        $mHTML.="<a name=\"".$row->terminnr."\"></a>";
        $mHTML.=Get_Wochentag($row->mWochentag).", ".$row->mDatum;
        $mHTML.="</div>";
        $mHTML.="<div class=\"div_Schicht_Header_right\">";
        if ($row->art == 0)
            $mHTML.="<b>".$zusText."Infostand:</b>";
        else
            $mHTML.="<b>".$zusText."Trolley:</b>";

        $mOrt = strtoupper($row->ort);
        $mHTML.=$mOrt;
        $mHTML.="</div>";
        $mHTML.="</div>";
        $mHTML.="<div class=\"div_Schichtrows\">";

        $SQLCommandSchichten="Select sch.terminnr, sch.von, sch.bis, sch.Schichtnr, ";
        $SQLCommandSchichten.="DATE_FORMAT(sch.von, '%H:%i') as Zeitvon, ";
        $SQLCommandSchichten.="DATE_FORMAT(sch.bis, '%H:%i') as Zeitbis ";
        $SQLCommandSchichten.="from schichten sch  ";
        $SQLCommandSchichten.="Where (sch.terminnr=".$row->terminnr.") ";
        $SQLCommandSchichten.="order by sch.Schichtnr ";
        $SQLResultSchichten=mysql_query($SQLCommandSchichten,$verbindung);
        while($rowSchichten = mysql_fetch_object($SQLResultSchichten))
        {

            $mHTML.="<div class=\"div_Schicht_Time\">".$rowSchichten->Zeitvon." - ".$rowSchichten->Zeitbis."</div>";
            $mHTML.="<div class=\"div_Schicht_Teilnehmer\"><table><tr>";
            $mAnzTD=0;
            $AllowApply=1;
            $SQLCommandSchTeil="SELECT SchTeil.teilnehmernr,SchTeil.status,SchTeil.isschichtleiter, ";
            $SQLCommandSchTeil.="muser.vorname as vorname, muser.nachname as nachname ";
            $SQLCommandSchTeil.="FROM schichten_teilnehmer SchTeil ";
            $SQLCommandSchTeil.="left outer join teilnehmer muser ";
            $SQLCommandSchTeil.="on SchTeil.teilnehmernr = muser.teilnehmernr ";
            $SQLCommandSchTeil.="Where (SchTeil.terminnr = ".$row->terminnr.") and ";
            $SQLCommandSchTeil.="(SchTeil.schichtnr = ".$rowSchichten->Schichtnr.") order by SchTeil.isschichtleiter DESC ";
            $SQLResultSchTeil=mysql_query($SQLCommandSchTeil,$verbindung);
            while($rowSchTeil = mysql_fetch_object($SQLResultSchTeil)) {
                if ($rowSchTeil->teilnehmernr == $_SESSION['ID']) {
                    $AllowApply=0;
                    if ($rowSchTeil->status == 0)
                        $class="Teilnehmer_Status0";

                    if ($rowSchTeil->status == 2)
                        if ($rowSchTeil->isschichtleiter == 1)
                            $class="Teilnehmer_Schichtleiter";
                        else
                            $class="Teilnehmer_Status2";

                    $mAnzTD = $mAnzTD + 1;
                    $mHTML.="<td class=\"".$class."\">".$rowSchTeil->vorname." ".$rowSchTeil->nachname;

                    if (($row->DiffDate > 3) || ($rowSchTeil->status == 0))
                      $mHTML.="<a href=\"index.php?Type=Schichten&SubType=DelUser&Terminnr=".$row->terminnr."&Schichtnr=".$rowSchichten->Schichtnr."#".$row->terminnr."\"><img src=\"images/Nein.png\" style=\"max-width:22px;max-height:22px;\"></a>";

                    $mHTML.="</td>";
                } else {
                    if ($rowSchTeil->status == 2) {
                        if ($rowSchTeil->isschichtleiter == 1)
                            $mHTML.="<td class=\"otherTeilnehmer_Schichtleiter\">";
                        else
                            $mHTML.="<td class=\"otherTeilnehmer\">";

                        $mAnzTD = $mAnzTD + 1;
                        $mHTML.=$rowSchTeil->vorname." ".$rowSchTeil->nachname."</td>";
                    }
                }
            }

            if ($mAnzTD >= 2)
                $AllowApply = 0;

            if ($AllowApply == 1) {
                $mAnzTD = $mAnzTD + 1;
                $mHTML.="<td  class=\"otherTeilnehmer\">";
                $mHTML.="<form action=\"index.php?Type=Schichten#".$row->terminnr."\" method=\"post\">";
                $mHTML.="<input type=\"hidden\" name=\"Terminnr\" Value=\"".$row->terminnr."\">";
                $mHTML.="<input type=\"hidden\" name=\"Schichtnr\" Value=\"".$rowSchichten->Schichtnr."\">";
                $mHTML.="<input type=\"submit\" name=\"SetSchicht\" value=\"bewerben\">";
                $mHTML.="</form>";
                $mHTML.="</td>";
            }
            $mHTML.="</tr></table>";
            $mHTML.="</div><div class=\"Div_Clear\"></div>";
        }

        $mHTML.="</div>";
        $mHTML.="<div class=\"div_Schicht_Footer\"></div>";
        $mHTML.="</div>";
    }
}
?>