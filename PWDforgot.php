<?php
include "DBConnect.php";
include "function.php";
$UserExists = -1;
$ShowPWDforgot=1;
if (isset($_POST["PWDMail"]))
{
  $SQLCommand="Select teilnehmernr,status,vorname,nachname,eMail from teilnehmer ";
  $SQLCommand.="Where (username ='".$_POST["PWDLoginname"]."') and (eMail='".$_POST["PWDMail"]."')";
  $SQLResult=mysql_query($SQLCommand,$verbindung);
  $AnzRow=mysql_num_rows($SQLResult);

  if ($AnzRow > 0) {
    $UserExists = 1;
    $SQLUpdatePWD="Update teilnehmer set pwd =";
  } else {
    $UserExists = 0;
  }

  if ($UserExists == 1) {
    $rowREG = mysql_fetch_object($SQLResult);
    $str_password_chars ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str_password = '';
    for ($i = 0; $i < 8; $i++)
    {
      mt_srand((double)microtime()*time());
      $str_password .= $str_password_chars{rand(0, strlen($str_password_chars)-1)};
    }

    $Betreff = 'Dein neues Passwort bei ' . $_SERVER['SERVER_NAME'];
    $text="Hallo ".$rowREG->vorname.",<br><br>";
    $text.="dein neues Passwort ist: ".$str_password."<br><br>";

    $SQLUpdatePWD.="'".md5($str_password)."'";
    $SQLUpdatePWD.=" Where (username ='".$_POST["PWDLoginname"]."') and (eMail='".$_POST["PWDMail"]."')";
    $SQLResult=mysql_query($SQLUpdatePWD,$verbindung);
    if (!$SQLResult)
    {
      echo "Passswort konnte nicht geändert werden. Bitte wenden Sie sich an den Support";
      $ShowPWDforgot=0;
      exit;
    }
    SendMail($rowREG->eMail,$Betreff,$text);

    $mHTML.="	<div class=\"div_PWDForgot\">";
    $mHTML.="	<h2>Neues Passwort</h2>";
    $mHTML.="Dein neues Passwort wurde per E-Mail and dich versendet";
    $mHTML.="	</div>";
    $ShowPWDforgot=0;
  }
}

if ($ShowPWDforgot==1)
{
  $mHTML.="	<div class=\"div_PWDForgot\">";
  $mHTML.="	<h2>Passwort vergessen</h2>";

  if ($UserExists == 0)
    $mHTML.="<font color=red>Der Benutzername und die E-Mail Adresse wurde im System nicht gefunden</font><br>";

  $mHTML.="Bitte trag dein Benutzername und deine E-Mail-Adresse ein<br><br>";
  $mHTML.="<form action=\"index.php?Type=PWDRequest\" method=\"post\">";
  $mHTML.="<table border=0>";
  $mHTML.="<tr>";
  $mHTML.="<td>Benutzername:</td>";
  $mHTML.="<td><input type=\"Text\" size=27 name=\"PWDLoginname\"></td>";
  $mHTML.="</tr>";
  $mHTML.="<tr>";
  $mHTML.="<td>eMail-Adresse:</td>";
  $mHTML.="<td><input type=\"Text\" size=27 name=\"PWDMail\"></td>";
  $mHTML.="</tr>";
  $mHTML.="<tr>";
  $mHTML.="<td></td>";
  $mHTML.="<td><input type=\"Submit\" value=\"neues Passwort anfordern\"></td>";
  $mHTML.="</tr>";
  $mHTML.="<td></td>";
  $mHTML.="</table>";
  $mHTML.="</form>";
  $mHTML.="</div>";
}
?>
