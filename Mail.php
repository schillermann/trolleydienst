<?php
  $ShowMail=1;
  include "function.php";
  if (isset($_POST['SendMail']))
  {
  	$SQLCommand="Select teilnehmernr, status, vorname, nachname, email , username , infostand, trolley, admin  ";
  	$SQLCommand.="from teilnehmer ";
  	$SQLCommand.="Where (status=0) ";

  	if ($_POST['Empfaenger'] == 1)
  		$SQLCommand.=" and (infostand=1) ";

  	if ($_POST['Empfaenger'] == 2)
  		$SQLCommand.=" and (trolley=1) ";

  	$mText = $_POST['Text'];
  	$mText = addslashes($mText);
  	$mText = nl2br(stripslashes($mText));
  	
  	$SQLResult=mysql_query($SQLCommand,$verbindung);
  	while($row = mysql_fetch_object($SQLResult))
  	{
  		$Title='Hallo '.$row->vorname.', <br><br>';
        SendMail($row->email,$_POST['Betreff'],$Title.$mText);
  	}
  	$mHTML.="<h3>Mail-Versand</h3>";
  	$mHTML.="<div class=\"div_Mail\">";
  	$mHTML.="Die E-Mail wurde erfolgreich versendet";
  	$mHTML.="</div>";
  	$ShowMail=0;
}

if ($ShowMail == 1)
{
    $Footer = GetFooter();
    $mHTML.="<h3>Mail-Versand</h3>";
    $mHTML.="<div class=\"div_Mail\">";
    $mHTML.="<form action=\"index.php?Type=Mail\" method=\"post\">";
    $mHTML.="<table border=0>";
    $mHTML.="<tr>";
    $mHTML.="<td>Empfänger:</td>";
    $mHTML.="<td><select name=\"Empfaenger\">";
    $mHTML.="<option value=\"0\" selected>alle</option>";
    $mHTML.="<option value=\"1\">Infostand</option>";
    $mHTML.="<option value=\"2\">Trolley</option>";
    $mHTML.="</select></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Betreff:</td>";
    $mHTML.="<td><input type=\"text\" name=\"Betreff\" size=\"61\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td valign=\"top\">Text:</td>";
    $mHTML.="<td>Hallo,</td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td valign=\"top\"></td>";
    $mHTML.="<td><textarea name=\"Text\" cols=\"45\" rows=\"11\"></textarea></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td valign=\"top\"></td>";
    $mHTML.="<td>".$Footer."</td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td></td>";
    $mHTML.="<td><input type=\"submit\" name=\"SendMail\" Value=\"senden\"></td>";
    $mHTML.="</tr>";
    $mHTML.="</table>";
    $mHTML.="</form>";
    $mHTML.="</div>";
}
  
?>