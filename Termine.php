<?php
include "function.php";
$ShowList=1;

if (isset($_POST['DelTermin'])) {
	$UpdateCommand="Delete from termine ";
	$UpdateCommand.="Where (terminnr = ".$_GET['DELID'].") ";
	$SQLResult=mysql_query($UpdateCommand,$verbindung);
}

if (isset($_GET['SubType'])) {
	if ($_GET['SubType'] == 'SetSL') {
		$UpdateCommand="Update schichten_teilnehmer ";
		$UpdateCommand.="set ";
		$UpdateCommand.="status =2, ";
		$UpdateCommand.="isschichtleiter =1  ";
		$UpdateCommand.="Where (terminnr = ".$_GET['Terminnr'].") and ";
		$UpdateCommand.="(Schichtnr = ".$_GET['Schichtnr'].") and ";
		$UpdateCommand.="(teilnehmernr = ".$_GET['Nr'].") ";
		$SQLResult=mysql_query($UpdateCommand,$verbindung);
	}

	if ($_GET['SubType'] == 'SetBack') {
		$UpdateCommand="Update schichten_teilnehmer ";
		$UpdateCommand.="set ";
		$UpdateCommand.="status =0, ";
		$UpdateCommand.="isschichtleiter =0 ";
		$UpdateCommand.="Where (terminnr = ".$_GET['Terminnr'].") and ";
		$UpdateCommand.="(Schichtnr = ".$_GET['Schichtnr'].") and ";
		$UpdateCommand.="(teilnehmernr = ".$_GET['Nr'].") ";
		$SQLResult=mysql_query($UpdateCommand,$verbindung);
	}

	if ($_GET['SubType'] == 'SetOK') {
		$UpdateCommand="Update schichten_teilnehmer ";
		$UpdateCommand.="set ";
		$UpdateCommand.="status =2 ";
		$UpdateCommand.="Where (terminnr = ".$_GET['Terminnr'].") and ";
		$UpdateCommand.="(Schichtnr = ".$_GET['Schichtnr'].") and ";
		$UpdateCommand.="(teilnehmernr = ".$_GET['Nr'].") ";
		$SQLResult=mysql_query($UpdateCommand,$verbindung);
	}

	if ($_GET['SubType'] == 'DelUser') {

		$SQLCommand="Select Teil.vorname,Teil.email,SchichtTeil.status, ";
		$SQLCommand.="Schicht.ort, DATE_FORMAT(Schicht.termin_von, '%d.%m.%Y') as mDatum ";
		$SQLCommand.="from schichten_teilnehmer SchichtTeil ";
		$SQLCommand.="inner join teilnehmer Teil ";
		$SQLCommand.="on SchichtTeil.teilnehmernr = Teil.teilnehmernr ";
		$SQLCommand.="inner join termine Schicht ";
		$SQLCommand.="on SchichtTeil.terminnr = Schicht.terminnr ";
		$SQLCommand.="Where (SchichtTeil.terminnr = ".$_GET['Terminnr'].") and ";
		$SQLCommand.="(SchichtTeil.Schichtnr = ".$_GET['Schichtnr'].") and ";
		$SQLCommand.="(SchichtTeil.teilnehmernr = ".$_GET['Nr'].") ";

		$SQLResult=mysql_query($SQLCommand,$verbindung);
		$row = mysql_fetch_object($SQLResult);

		if ($row->status == 2)
		{
			$Body='Hallo '.$row->vorname.', <br><br>';
			$Body.='aus organisatorischen Gründen wurde deine Schicht vom '.$row->mDatum.' in '.$row->ort.' zurückgenommen';
			SendMail($row->email,'Schicht zurückgenommen',$Body);
		}

		$DeleteCommand="Delete from schichten_teilnehmer ";
		$DeleteCommand.="Where (terminnr = ".$_GET['Terminnr'].") and ";
		$DeleteCommand.="(Schichtnr = ".$_GET['Schichtnr'].") and ";
		$DeleteCommand.="(teilnehmernr = ".$_GET['Nr'].") ";
		$SQLResult=mysql_query($DeleteCommand,$verbindung);
	}

	if ($_GET['SubType'] == 'AddUser')
	{
		$UpdateCommand="Insert Into schichten_teilnehmer ";
		$UpdateCommand.="(terminnr, schichtnr, teilnehmernr, status, isschichtleiter) ";
		$UpdateCommand.="VALUES (";
		$UpdateCommand.=$_GET['Terminnr'].",".$_GET['Schichtnr'].",".$_POST['NewRegUser'].",2,0)";
		$SQLResult=mysql_query($UpdateCommand,$verbindung);
	}
}

if (isset($_POST['SaveNewDS'])) {
	$a=0;

	if ($_POST['Terminserie'] != "") {
		$pos = strpos($_POST['Terminserie'], ".");
		$mTag = substr($_POST['Terminserie'],0,$pos);
		$pos_Monat = strpos($_POST['Terminserie'], ".",$pos + 1);
		$mMonat = substr($_POST['Terminserie'],$pos + 1,$pos_Monat - $pos - 1);
		$mJahr = substr($_POST['Terminserie'],$pos_Monat + 1);
		$TerminSerieBis = strtotime($mJahr.'-'.$mMonat.'-'.$mTag);
	}
	//02.03.2014
	$mDatumfaellig="";
	$pos = strpos($_POST['Datum'], ".");
	if ($pos > 0)
	{
		$mTag = substr($_POST['Datum'],0,$pos);
		$pos_Monat = strpos($_POST['Datum'], ".",$pos + 1);
		$mMonat = substr($_POST['Datum'],$pos + 1,$pos_Monat - $pos - 1);
		$mJahr = substr($_POST['Datum'],$pos_Monat + 1);

	}

	while ($a==0) {
		$terminnr=1;
		$sqlcommand="Select coalesce(Max(terminnr),0) + 1 as terminnr from termine";
		$SQLResult=mysql_query($sqlcommand,$verbindung);
		$row=mysql_fetch_object($SQLResult);
		if ($row->terminnr > 0)
			$terminnr = $row->terminnr;

		$Sonderschicht="0";
		if(in_array("Sonderschicht",$_POST['Sonderschicht']))
			$Sonderschicht="1";

		$InsertCommand="Insert Into termine (";
		$InsertCommand.="terminnr,art,ort,termin_von,termin_bis,sonderschicht) ";
		$InsertCommand.="VALUES (";
		$InsertCommand.=$terminnr.",".$_POST['Art'].",'".$_POST['ort']."','";
		$InsertCommand.=$mJahr."-".$mMonat."-".$mTag." ".$_POST['von'].":00','";
		$InsertCommand.=$mJahr."-".$mMonat."-".$mTag." ".$_POST['bis'].":00',".$Sonderschicht.")";
		$SQLResult=mysql_query($InsertCommand,$verbindung);
		if (!$SQLResult)
			exit("Termin konnte nicht gespeichert werden");

		Get_SetSchichten($terminnr,$_POST['Stundenanzahl']);

		if ($_POST['Terminserie'] != "") {
			$Serie_NewDatum = strtotime('+7 days', strtotime($mJahr.'-'.$mMonat.'-'.$mTag));
			if ($TerminSerieBis >= $Serie_NewDatum) {
				$mJahr = date('Y', $Serie_NewDatum);
				$mMonat = date('m', $Serie_NewDatum);
				$mTag = date('d', $Serie_NewDatum);
			} else {
				$a = 1;
			}
		} else {
			$a=1;
		}
	}
}

if (isset($_POST['SaveEditClient'])) {

	//2.3.2014
	//02.03.2014
	$mDatumfaellig="";
	$pos = strpos($_POST['Datum'], ".");
	if ($pos > 0)
	{
		$mTag = substr($_POST['Datum'],0,$pos);
		$pos_Monat = strpos($_POST['Datum'], ".",$pos + 1);
		$mMonat = substr($_POST['Datum'],$pos + 1,$pos_Monat - $pos - 1);
		$mJahr = substr($_POST['Datum'],$pos_Monat + 1);
	}

	$Sonderschicht="0";
	if(in_array("Sonderschicht",$_POST['Sonderschicht']))
		$Sonderschicht="1";

	$UpdateCommand="Update termine ";
	$UpdateCommand.="set ";
	$UpdateCommand.="art='".$_POST['Art']."', ";
	$UpdateCommand.="ort='".$_POST['ort']."', ";
	$UpdateCommand.="termin_von='".$mJahr."-".$mMonat."-".$mTag." ".$_POST['von'].":00',";
	$UpdateCommand.="termin_bis='".$mJahr."-".$mMonat."-".$mTag." ".$_POST['bis'].":00', ";
	$UpdateCommand.="sonderschicht=".$Sonderschicht." ";

	$UpdateCommand.="Where (terminnr = ".$_GET['ID'].")";
	$SQLResult=mysql_query($UpdateCommand,$verbindung);
	if (!$SQLResult)
        exit("Termin konnte nicht gespeichert werden");
	Get_SetSchichten($_GET['ID']);
}

if (isset($_POST['NewDS'])) {
	$ShowList=0;
	$mHTML.="<h3>Neuer Termin</h3>";
	$mHTML.="<form action=\"index.php?Type=Termine\" method=\"post\">";
	$mHTML.="<table border=0 cellspacing=0>";
	$mHTML.="<colgroup>";
	$mHTML.="<COL WIDTH=150>";
	$mHTML.="<COL WIDTH=150>";
	$mHTML.="</colgroup>";;
	$mHTML.="<tr>";
	$mHTML.="<td>Schichtart:</td>";
	$mHTML.="<td>";
	$mHTML.="<select name=\"Art\">";
	$mHTML.="<option value=\"0\">Infostand</option>";
	$mHTML.="<option value=\"1\" selected>Trolley</option>";
	$mHTML.="</select>";
	$mHTML.="</td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>Ort:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"ort\" size=30></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>Datum:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"Datum\" size=30></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>von:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"von\" size=30 value=\"10:00\"></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>bis:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"bis\" size=30 value=\"18:00\"></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>Sonderschicht:</td>";
	$mHTML.="<td><input type=\"checkbox\" name=\"Sonderschicht[]\" value=\"Sonderschicht\" ></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>Stundenanzahl:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"Stundenanzahl\" size=30 value=\"1\"></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>Terminserie bis zum:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"Terminserie\" size=30 value=\"\"></td>";
	$mHTML.="</tr>";

	$mHTML.="</table>";
	$mHTML.="<input type=\"Submit\" name=\"SaveNewDS\" value=\"Speichern\">";
	$mHTML.="</form></br>";
}


if (isset($_GET['ASKDELID'])) {
	$ShowList=0;
	$SQLCommand="Select terminnr , art , ort, ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%d.%m.%Y') as mDatum, ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%H:%i') as mvon, ";
	$SQLCommand.="DATE_FORMAT(termin_bis, '%H:%i') as mbis ";
	$SQLCommand.="from termine ";
	$SQLCommand.="Where (terminnr  = '".$_GET['ASKDELID']."')";
	//echo $SQLCommand;
	$SQLResult=mysql_query($SQLCommand,$verbindung);
	$row = mysql_fetch_object($SQLResult);
	$mHTML.="<h3>Termin l&ouml;schen</h3>";
	$mHTML.="<form action=\"index.php?Type=Termine&DELID=".$_GET['ASKDELID']."\" method=\"post\">";
	$mHTML.="Möchten Sie den Termin am ".$row->mDatum." wirklich l&ouml;schen?</br>";
	$mHTML.="<input type=\"submit\" name=\"DelTermin\" value=\"Ja\"> ";
	$mHTML.="<input type=\"submit\" name=\"NotDelTermin\" value=\"Nein\">";
	$mHTML.="<form>";
}


if (isset($_GET['ID'])) {
	$ShowList=0;
	$SQLCommand="Select terminnr , art , ort, ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%d.%m.%Y') as mDatum, ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%H:%i') as mvon, ";
	$SQLCommand.="DATE_FORMAT(termin_bis, '%H:%i') as mbis, ";
	$SQLCommand.="coalesce(sonderschicht,0) as sonderschicht ";
	$SQLCommand.="from termine ";
	$SQLCommand.="Where (terminnr  = '".$_GET['ID']."')";
	//echo $SQLCommand;
	$SQLResult=mysql_query($SQLCommand,$verbindung);
	$row = mysql_fetch_object($SQLResult);

	$mHTML.="<h3>Termin bearbeiten</h3>";
	$mHTML.="<form action=\"index.php?Type=Termine&ID=".$_GET['ID']."\" method=\"post\">";
	$mHTML.="<table border=0 cellspacing=0>";
	$mHTML.="<colgroup>";
	$mHTML.="<COL WIDTH=150>";
	$mHTML.="<COL WIDTH=150>";
	$mHTML.="</colgroup>";
	$mHTML.="<tr>";
	$mHTML.="<td>Schichtart:</td>";
	$mHTML.="<td>";
	$mHTML.="<select name=\"Art\">";
	$mHTML.="<option value=\"0\" ";
	if ($row->art == 0)
		$mHTML.=" selected ";

	$mHTML.=">Infostand</option>";
	$mHTML.="<option value=\"1\" ";
	if ($row->art == 1)
		$mHTML.=" selected ";

	$mHTML.=">Trolley</option>";
	$mHTML.="</select>";
	$mHTML.="</td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>Ort:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"ort\" size=30 value=\"".$row->ort."\"></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>Datum:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"Datum\" size=30 value=\"".$row->mDatum."\"></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>von:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"von\" size=30 value=\"".$row->mvon."\"></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>bis:</td>";
	$mHTML.="<td><input type=\"Text\" name=\"bis\" size=30 value=\"".$row->mbis."\"></td>";
	$mHTML.="</tr>";
	$mHTML.="<tr>";
	$mHTML.="<td>Sonderschicht:</td>";
	$mHTML.="<td><input type=\"checkbox\" name=\"Sonderschicht[]\" value=\"Sonderschicht\" ";
	if ($row->sonderschicht == 1)
		$mHTML.=" checked ";

	$mHTML.="></td>";
	$mHTML.="</tr>";
	$mHTML.="</table>";
	$mHTML.="<input type=\"Submit\" name=\"SaveEditClient\" value=\"Speichern\">";
	$mHTML.="</form></br>";
}

if ($ShowList==1) {

	if (!isset($_SESSION['AdminFilterDays']))
		$_SESSION['AdminFilterDays'] = 0;

	if (isset($_POST['FilterTerminTage']))
		$_SESSION['AdminFilterDays'] = $_POST['FilterTerminTage'];

	$InfostandUser = GetUserLookup(0);
	$TrolleyUser = GetUserLookup(1);

	$mHTML.="<h3>Termine</h3>";
	$mHTML.="<form action=\"index.php?Type=Termine\" method=\"POST\">";
	$mHTML.="<table border=0>";
	$mHTML.="<tr>";
	$mHTML.="<td>Termine der letzten <input type=\"text\" name=\"FilterTerminTage\" value=\"".$_SESSION['AdminFilterDays']."\" size=\"3\"> Tage anzeigen <input type=\"submit\" name=\"Refresh\" value=\"Aktualisieren\"></td>";
	$mHTML.="</tr>";
	$mHTML.="</table>";
	$mHTML.="<form>";
	$mHTML.="</frameset>";
	$mHTML.="</br>";
	$mHTML.="<form action=\"index.php?Type=Termine\" method=\"POST\">";
	$mHTML.="<input type=\"submit\" name=\"NewDS\" value=\"Neuen Termin\"></form>";
	$mHTML.="</br><div class=\"div_Legende\">";
	$mHTML.="<table border=0>";
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
	$mHTML.="<td class=\"Teilnehmer_Status0_Legende\"></td>";
	$mHTML.="<td class=\"Legende\">beworben</td>";
	$mHTML.="<td class=\"Teilnehmer_Status2_Legende\"></td>";
	$mHTML.="<td class=\"Legende\">bestätigt</td>";
	$mHTML.="<td class=\"Teilnehmer_Schichtleiter_Legende\"></td>";
	$mHTML.="<td class=\"Legende\">Schichtleiter</td>";
	$mHTML.="</tr>";
	$mHTML.="</table>";
	$mHTML.="</div>";
	$SQLCommand="Select terminnr , art , ort , ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%d.%m.%Y') as mDatum, ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%w') as mWochentag, ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%H:%i') as mVon, ";
	$SQLCommand.="DATE_FORMAT(termin_bis, '%H:%i') as mBis, ";
	$SQLCommand.="coalesce(sonderschicht,0) as sonderschicht ";
	$SQLCommand.="from termine  ";
	$SQLCommand.=" Where (datediff(curdate(),termin_von) <= ".$_SESSION['AdminFilterDays']." ) ";

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

		$mType=0;
		$mHTML.="<div class=\"div_Schicht\" style=\"background-color:".$Farbe.";\">";
		$mHTML.="<div class=\"div_Schicht_Header\">";
		$mHTML.="<div class=\"div_Schicht_Header_left\">";
		$mHTML.="<a name=\"".$row->terminnr."\"></a>";
		$mHTML.=Get_Wochentag($row->mWochentag).", ".$row->mDatum;
		$mHTML.="</div>";
		$mHTML.="<div class=\"div_Schicht_Header_right\">";
		if ($row->art == 0) {
			$mHTML.="<b>".$zusText."Infostand:</b>";
			$mType = 0;
		} else {
			$mHTML.="<b>".$zusText."Trolley:</b>";
			$mType = 1;
		}
		$mHTML.=$row->ort;
		$mHTML.="<a href=\"index.php?Type=Termine&ID=".$row->terminnr."\"><img src=\"images/edit.png\" style=\"max-width:22px;max-height:22px;\"></a>";
		$mHTML.="<a href=\"index.php?Type=Termine&ASKDELID=".$row->terminnr."\"><img src=\"images/Nein.png\" style=\"max-width:22px;max-height:22px;\"></a>";
		$mHTML.="</div>";
		$mHTML.="</div>";
		$mHTML.="<div class=\"div_Schichtrows\">";
		$SQLCommandSchichten="Select sch.terminnr, sch.von, sch.bis, sch.Schichtnr, ";
		$SQLCommandSchichten.="DATE_FORMAT(sch.von, '%H:%i') as Zeitvon, ";
		$SQLCommandSchichten.="DATE_FORMAT(sch.bis, '%H:%i') as Zeitbis ";
		$SQLCommandSchichten.="from schichten sch ";
		$SQLCommandSchichten.="Where (sch.terminnr=".$row->terminnr.") ";
		$SQLCommandSchichten.="order by sch.Schichtnr ";
		$SQLResultSchichten=mysql_query($SQLCommandSchichten,$verbindung);
		while($rowSchichten = mysql_fetch_object($SQLResultSchichten)) {

			$SQLCommandSchTeil="SELECT count(*) as Anz  ";
			$SQLCommandSchTeil.="FROM schichten_teilnehmer SchTeil ";
			$SQLCommandSchTeil.="Where (SchTeil.terminnr = ".$row->terminnr.") and ";
			$SQLCommandSchTeil.="(SchTeil.schichtnr = ".$rowSchichten->Schichtnr.") and ";
			$SQLCommandSchTeil.="(SchTeil.isschichtleiter = 1) ";
			$SQLResultSchTeil=mysql_query($SQLCommandSchTeil,$verbindung);
			$rowSchTeil = mysql_fetch_object($SQLResultSchTeil);
			$mAnzSchichtleiter = $rowSchTeil->Anz;
			$mHTML.="<div class=\"div_Schicht_Time\">".$rowSchichten->Zeitvon." - ".$rowSchichten->Zeitbis."</div>";
			$mHTML.="<div class=\"div_Schicht_Teilnehmer\"><table><tr>";
            $mAnzTD=0;
			$AllowApply=1;
			$mAnzAktiv=0;
			$SQLCommandSchTeil="SELECT SchTeil.teilnehmernr,SchTeil.status,SchTeil.isschichtleiter, ";
			$SQLCommandSchTeil.="muser.vorname as vorname, muser.nachname as nachname, ";
			$SQLCommandSchTeil.="muser.versammlung, muser.sprache, muser.infostand, muser.trolley, ";
			$SQLCommandSchTeil.="coalesce(muser.Bemerkung,'') as UserBemerkung,  ";
			$SQLCommandSchTeil.="coalesce(muser.MaxSchichten,2) as MaxSchichten,  ";
			$SQLCommandSchTeil.="coalesce(muser.TeilnehmerBemerkung,'') as TeilnehmerBemerkung  ";
			$SQLCommandSchTeil.="FROM schichten_teilnehmer SchTeil ";
			$SQLCommandSchTeil.="left outer join teilnehmer muser ";
			$SQLCommandSchTeil.="on SchTeil.teilnehmernr = muser.teilnehmernr ";
			$SQLCommandSchTeil.="Where (SchTeil.terminnr = ".$row->terminnr.") and ";
			$SQLCommandSchTeil.="(SchTeil.schichtnr = ".$rowSchichten->Schichtnr.") ";
			$SQLResultSchTeil=mysql_query($SQLCommandSchTeil,$verbindung);

			while($rowSchTeil = mysql_fetch_object($SQLResultSchTeil)) {
				$AddSchulung='';
				if ($row->art == 0)
					if ($rowSchTeil->infostand == 2)
						$AddSchulung='Schulung, ';
				else
					if ($rowSchTeil->trolley == 2)
						$AddSchulung='Schulung, ';

				$mAnzTD = $mAnzTD + 1;

				if ($mAnzTD > 0) {
					$mHTML.="</tr><tr>";
					$mAnzTD= 0;
				}

				if ($rowSchTeil->status == 0)
					$class="Teilnehmer_Status0";

				if ($rowSchTeil->status == 2) {
					$mAnzAktiv = $mAnzAktiv + 1;
					if ($rowSchTeil->isschichtleiter == 1)
						$class="Teilnehmer_Schichtleiter";
					else
						$class="Teilnehmer_Status2";
				}
				$mHTML.="<td class=\"".$class." td_Teilnehmer\" style=\"position:relative;\">".$rowSchTeil->vorname." ".$rowSchTeil->nachname." (".$AddSchulung.$rowSchTeil->versammlung.")";

				if ($rowSchTeil->status == 0)
					$mHTML.="  <a href=\"index.php?Type=Termine&SubType=SetOK&Terminnr=".$row->terminnr."&Schichtnr=".$rowSchichten->Schichtnr."&Nr=".$rowSchTeil->teilnehmernr."#".$row->terminnr."\"><img src=\"images/Ja.png\" style=\"max-width:22px;max-height:22px;\"></a>";
				else
					$mHTML.="  <a href=\"index.php?Type=Termine&SubType=SetBack&Terminnr=".$row->terminnr."&Schichtnr=".$rowSchichten->Schichtnr."&Nr=".$rowSchTeil->teilnehmernr."#".$row->terminnr."\"><img src=\"images/goback.png\" style=\"max-width:22px;max-height:22px;\"></a>";

				if ($mAnzSchichtleiter == 0)
				  $mHTML.="  <a href=\"index.php?Type=Termine&SubType=SetSL&Terminnr=".$row->terminnr."&Schichtnr=".$rowSchichten->Schichtnr."&Nr=".$rowSchTeil->teilnehmernr."#".$row->terminnr."\"><img src=\"images/SL.png\" style=\"max-width:22px;max-height:22px;\"></a>";

				$mHTML.="<a href=\"index.php?Type=Termine&SubType=DelUser&Terminnr=".$row->terminnr."&Schichtnr=".$rowSchichten->Schichtnr."&Nr=".$rowSchTeil->teilnehmernr."#".$row->terminnr."\"><img src=\"images/Nein.png\" style=\"max-width:22px;max-height:22px;\"></a>";

				$BemerkungsText="";
				if ($rowSchTeil->MaxSchichten != '')
					$BemerkungsText.="<b>Stunden/Tag:</b>".$rowSchTeil->MaxSchichten."<br>";

				if ($rowSchTeil->TeilnehmerBemerkung != '')
					$BemerkungsText.="<b>Bemerkung:</b><br>".$rowSchTeil->TeilnehmerBemerkung."<br>";

				if ($rowSchTeil->UserBemerkung != '')
					$BemerkungsText.="<b>interne Bemerkung:</b><br>".$rowSchTeil->UserBemerkung."<br>";

				if ($BemerkungsText != '')
					$mHTML.="<div class=\"arrow_box\">".$BemerkungsText."</div>";

				$mHTML.="</td>";
			}

			$mHTML.="</tr><tr>";
			$mHTML.="<td>";

			$mHTML.="<form action=\"index.php?Type=Termine&SubType=AddUser&Terminnr=".$row->terminnr."&Schichtnr=".$rowSchichten->Schichtnr."#".$row->terminnr."\" method=\"POST\">";

			if ($mType == 0)
				$mHTML.="<select name=\"NewRegUser\">".$InfostandUser."</select>";
			else
				$mHTML.="<select name=\"NewRegUser\">".$TrolleyUser."</select>";

			$mHTML.="<input type=\"submit\" name=\"AddSchichtuser\" value=\"Hinzufügen\"></form>";
			$mHTML.="</td>";

			if ($mAnzSchichtleiter == 0)
				if ($mAnzAktiv >= 2)
					if ($row->art == 0)
						$mHTML.="<td><font color=\"red\">Schichtleiter fehlt</td>";

			$mHTML.="</tr></table>";
			$mHTML.="</div><div class=\"Div_Clear\"></div>";
		}

		$mHTML.="</div>";
		$mHTML.="<div class=\"div_Schicht_Footer\"></div>";
		$mHTML.="</div>";
	}

	$mHTML.="<script type=\"text/javascript\"> ";
	$mHTML.="$('.td_Teilnehmer').hover(function(){ ";
	$mHTML.=" $(this).find('.arrow_box').show(); ";
	$mHTML.="}); ";
	$mHTML.="$('.td_Teilnehmer a').hover(function(){ ";
	$mHTML.=" $(this).parent().find('.arrow_box').show(); ";
	$mHTML.="}); ";
	$mHTML.="$('.td_Teilnehmer').mouseout(function () { ";
	$mHTML.="	$(this).find('.arrow_box').hide(); ";
	$mHTML.="}); ";
	$mHTML.="$('.arrow_box').hover(function(){ ";
	$mHTML.=" $(this).show(); ";
	$mHTML.="}); ";
	$mHTML.="$('.arrow_box').mouseout(function () { ";
	$mHTML.="	$(this).hide(); ";
	$mHTML.="}); ";
	$mHTML.="</script> ";
}
?>