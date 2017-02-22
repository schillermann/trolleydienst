<?php
  session_start();
  include "DBConnect.php";

  if (isset($_GET['Logout']))
  {
    unset($_SESSION['ID']);
    unset($_SESSION['Name']);
    unset($_SESSION['eMail']);
    unset($_SESSION['infostand']);
    unset($_SESSION['trolley']);
    unset($_SESSION['admin']);
  }
	  
  $LoginError = 0;
  if (isset($_POST['Setlogin']))
  {
    $SQLREG="Select teilnehmernr, vorname,nachname,email, ";
    $SQLREG.="coalesce(infostand,0) as infostand, ";
    $SQLREG.="coalesce(trolley,0) as trolley, ";
    $SQLREG.="coalesce(admin,0) as admin ";
    $SQLREG.="from teilnehmer ";
    $SQLREG.="Where (username='".$_POST['login_name']."') and (pwd='".md5($_POST['login_PWD'])."') ";

    $SQLResultREG=mysql_query($SQLREG,$verbindung);
    $AnzRow=mysql_num_rows($SQLResultREG);
    if ($AnzRow > 0) 
    {
          $rowREG = mysql_fetch_object($SQLResultREG);
          $_SESSION['ID'] = $rowREG->teilnehmernr;
          $_SESSION['Name'] = $rowREG->vorname." ".$rowREG->nachname;
          $_SESSION['eMail'] = $rowREG->email;

          if ($rowREG->infostand == 1)
            $_SESSION['infostand'] = 1;
	  	  else
          	if ($rowREG->infostand == 2)
          		$_SESSION['infostand'] = 1;
          	else
            	$_SESSION['infostand'] = 0;
          
          if ($rowREG->trolley == 1)
          	$_SESSION['trolley'] = 1;
          else
          	if ($rowREG->trolley == 2)
          		$_SESSION['trolley'] = 1;
          	else
          		$_SESSION['trolley'] = 0;
          
          if ($rowREG->admin == 1)
          	$_SESSION['admin'] = 1;
          else
          	$_SESSION['admin'] = 0;
          
          $UpdateCommand="Update teilnehmer ";
          $UpdateCommand.="set ";
          $UpdateCommand.="LastLoginTime= NOW() ";
          $UpdateCommand.="Where (teilnehmernr = '".$_SESSION['ID']."')";
          $SQLResult=mysql_query($UpdateCommand,$verbindung);
          
          header('location: index.php?Type=Schichten');
    }
    else
    {
       $LoginError=1;
    }
  }

  $mHTML="<html>";
  $mHTML.="<header>";
  $mHTML.="<title>Schichtplanung</title>";
  $mHTML.="<meta charset=\"utf-8\"/>";
  
  $mHTML.="<link rel=\"stylesheet\" type=\"text/css\" href=\"css/main.css\">";
  $mHTML.="<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js\"></script>";  
 
  $mHTML.="</header>";
  $mHTML.="<body>";
  $mHTML.="<div class=\"div_page\">";
  $mHTML.="<div class=\"div_logo\"><img src=\"images/Logo.png\" style=\"max-height:120px;\"></div>";
  $mHTML.="<div class=\"div_HeaderRight\">";
  
  $mHTML.="<div class=\"div_HeaderTitleleft\">";  
  $mHTML.="</div>";
  
  $mHTML.="<div class=\"div_HeaderTitleright\">";
  if (isset($_SESSION['ID']))
  {
  	$mHTML.="Willkommen ".$_SESSION['Name']." - <a href=\"index.php?Logout=Logout\">Abmelden</a>";
  }
  
  $mHTML.="</div>";
  $mHTML.="</div>";
  $mHTML.="<div class=\"Div_Clear\"></div>";
  $mHTML.="<div class=\"div_Menu\">";
  $mHTML.="<ul>";
  $mHTML.="<li><a href=\"index.php?Type=Schichten\">Schichten</a></li>";
  $mHTML.="<li><a href=\"index.php?Type=Infos\">News</a></li>";
  $mHTML.="<li><a href=\"index.php?Type=Profil\">Profil</a></li>";
  if (isset($_SESSION['admin']))
  {
    if ($_SESSION['admin'] == 1)
    {
    	$mHTML.="<li><a href=\"index.php?Type=Teilnehmer\">Teilnehmer</a></li>";
    	$mHTML.="<li><a href=\"index.php?Type=Termine\">Termine</a></li>";
    	$mHTML.="<li><a href=\"index.php?Type=Mail\">E-Mail</a></li>";
    	 
    }	
  }
  $mHTML.="</ul>";    
  $mHTML.="</div>";
  $mHTML.="<div class=\"div_MainTypePage\">";
  
  if (isset($_SESSION['ID']))
  {
  
    if (isset($_GET['Type']))
    {
    	
      if ($_GET['Type'] == 'Schichten')
    	  include "Schichten.php";

      if ($_GET['Type'] == 'Infos')
      	include "News.php";

      
      if ($_GET['Type'] == 'Profil')
      	include "Profil.php";

  	  if ($_GET['Type'] == 'Teilnehmer')
  		  include "user.php";

  	  if ($_GET['Type'] == 'Termine')
  		  include "Termine.php";

  	  if ($_GET['Type'] == 'Mail')
  	  	include "Mail.php";

  	  if ($_GET['Type'] == 'UserLastLogin')
  	  	include "UserLastActivity.php";
    }
    else 
    {
    	include "Schichten.php";
    }
  }
  else 
  {
  	
  	$ShowLogin=1;
  	if (isset($_GET['Type']))
  	{
  		if ($_GET['Type'] == 'PWDRequest')
  		{
  			include "PWDforgot.php";
  			$ShowLogin=0;
  		}
  	}
  	
  	if ($ShowLogin == 1)
  	{
  	$mHTML.="<div class=\"div_Anmeldung\">";

  	if ($LoginError == 1)
  		$mHTML.="<font color=\"#FF0000\">Anmeldung fehlgeschlagen</font>";

    $mHTML.="<form action=\"index.php\" method=\"post\">";
    $mHTML.="<table border=0>";
    
    $mHTML.="<tr>";
    $mHTML.="<td>Benutzername</td>";
    $mHTML.="<td><input type=\"text\" name=\"login_name\"></td>";
    $mHTML.="</tr>";
    
    $mHTML.="<tr>";
    $mHTML.="<td>Passwort:</td>";
    $mHTML.="<td><input type=\"password\" name=\"login_PWD\"></td>";
    $mHTML.="</tr>";    
    
    $mHTML.="<tr>";
    $mHTML.="<td></td>";
    $mHTML.="<td><input type=\"submit\" name=\"Setlogin\" Value=\"Anmelden\"></td>";
    $mHTML.="</tr>";    
    
    $mHTML.="<tr>";
    $mHTML.="<td></td>";
    $mHTML.="<td><a href=\"index.php?Type=PWDRequest\">Passwort vergessen</a></td>";
    $mHTML.="</tr>";
    
    $mHTML.="</table>";
    $mHTML.="</form>"; 
    $mHTML.="</div>";
  	}
  }
  $mHTML.="</div>";  
  $mHTML.="</div>";
  $mHTML.="</body>";
  $mHTML.="</html>";
  
  echo $mHTML;
?>