<?php
$ChangePWDError = 0;
$IsPWDChanged=0;
if (isset($_POST['SaveProfil']))
{
	$UpdateCommand="Update teilnehmer ";
	$UpdateCommand.="set ";
	$UpdateCommand.="vorname='".$_POST['vorname']."', ";
	$UpdateCommand.="nachname='".$_POST['nachname']."', ";
	$UpdateCommand.="email='".$_POST['email']."', ";
	$UpdateCommand.="Telefonnr='".$_POST['Telefonnr']."', ";
	$UpdateCommand.="Handy='".$_POST['Handy']."', ";
	$UpdateCommand.="MaxSchichten='".$_POST['MaxSchichten']."', ";
	$UpdateCommand.="TeilnehmerBemerkung='".$_POST['TeilnehmerBemerkung']."' ";
	
	$UpdateCommand.="Where (teilnehmernr = ".$_SESSION['ID'].")";
	$SQLResult=mysql_query($UpdateCommand,$verbindung);
	if (!$SQLResult)
	{
		echo "Profil konnte nicht gespeichert werden";
		exit;
	}
}

if (isset($_POST['ChangePWD']))
{
	$ChangePWDError=0;
	if ($_POST['Passwort'] != "")
		if ($_POST['Passwort'] != $_POST['Passwort2'])
			$ChangePWDError=2;
	else
		$ChangePWDError=1;
	
	if ($ChangePWDError == 0)
	{
		$UpdateCommand="Update teilnehmer ";
		$UpdateCommand.="set ";
		$UpdateCommand.="pwd='".md5($_POST['Passwort'])."' ";

		$UpdateCommand.="Where (teilnehmernr = ".$_SESSION['ID'].")";
		$SQLResult=mysql_query($UpdateCommand,$verbindung);
		if (!$SQLResult)
            exit("Profil konnte nicht gespeichert werden");

		$IsPWDChanged=1;
	}
}


$SQLCommand="Select vorname,nachname,email,Telefonnr,Handy,versammlung, ";
$SQLCommand.="sprache, coalesce(MaxSchichten,'2') as MaxSchichten, coalesce(TeilnehmerBemerkung,'') as TeilnehmerBemerkung ";
$SQLCommand.="from teilnehmer  ";
$SQLCommand.="Where (teilnehmernr  = '".$_SESSION['ID']."')";

$SQLResult=mysql_query($SQLCommand,$verbindung);
$row = mysql_fetch_object($SQLResult);

$mHTML.="<h3>Profil</h3>";
if ($IsPWDChanged == 1)
{
	$mHTML.="Passwort wurde erfolgreich ge&auml;ndert";
}
$mHTML.="<fieldset style=\"width:470px\">";
$mHTML.="<legend>Kontaktdaten</legend>";
$mHTML.="<form action=\"index.php?Type=Profil\" method=\"post\">";
$mHTML.="<table border=0 cellspacing=0>";
$mHTML.="<colgroup>";
$mHTML.="<COL WIDTH=150>";
$mHTML.="<COL WIDTH=150>";
$mHTML.="</colgroup>";

$mHTML.="<tr>";
$mHTML.="<td>Vorname:</td>";
$mHTML.="<td><input type=\"Text\" name=\"vorname\" size=30 value=\"".$row->vorname."\"></td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="<td>Nachname:</td>";
$mHTML.="<td><input type=\"Text\" name=\"nachname\" size=30 value=\"".$row->nachname."\"></td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="<td>E-Mail:</td>";
$mHTML.="<td><input type=\"Text\" name=\"email\" size=30 value=\"".$row->email."\"></td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="<td>Telefonnr:</td>";
$mHTML.="<td><input type=\"Text\" name=\"Telefonnr\" size=30 value=\"".$row->Telefonnr."\"></td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="<td>Handy:</td>";
$mHTML.="<td><input type=\"Text\" name=\"Handy\" size=30 value=\"".$row->Handy."\"></td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="<td>Max Stunden/Tag:</td>";
$mHTML.="<td><input type=\"Text\" name=\"MaxSchichten\" size=5 value=\"".$row->MaxSchichten."\"></td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="<td>Bemerkung:</td>";
$mHTML.="<td><textarea name=\"TeilnehmerBemerkung\" cols=\"40\" rows=\"5\">".$row->TeilnehmerBemerkung."</textarea></td>";
$mHTML.="</tr>";
$mHTML.="</table>";
$mHTML.="<input type=\"Submit\" name=\"SaveProfil\" value=\"Speichern\">";
$mHTML.="</form></fieldset></br>";
$mHTML.="<fieldset style=\"width:470px\">";
$mHTML.="<legend>Passwort</legend>";
$mHTML.="<form action=\"index.php?Type=Profil\" method=\"post\">";
$mHTML.="<table border=0 cellspacing=0>";
$mHTML.="<colgroup>";
$mHTML.="<COL WIDTH=150>";
$mHTML.="<COL WIDTH=150>";
$mHTML.="</colgroup>";
if ($ChangePWDError != 0)
{
	$mHTML.="<tr>";
	$mHTML.="<td></td>";
	$mHTML.="<td><font color=red>";

	if ($ChangePWDError == 1)
		$mHTML.="Bitte gib einen Passwort ein";
	if ($ChangePWDError == 2)
		$mHTML.="Beide Passw&ouml;rte stimmten nicht &uuml;berein";

	$mHTML.="</font></td>";
	$mHTML.="</tr>";
}
$mHTML.="<tr>";
$mHTML.="<td>neues Passwort:</td>";
$mHTML.="<td><input type=\"Password\" name=\"Passwort\" size=30></td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="<tr>";
$mHTML.="<td>neues Passwort (wiederholen):</td>";
$mHTML.="<td><input type=\"Password\" name=\"Passwort2\" size=30></td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="</table>";
$mHTML.="<input type=\"Submit\" name=\"ChangePWD\" value=\"Passwort &auml;ndern\">";
$mHTML.="</form></fieldset></br>";

?>