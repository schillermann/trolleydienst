<?php
  $ShowNews=1;

  if (isset($_GET['DowID']))
  {
  	$SQLCommand="Select ID,Bezeichnung,Dateiname,ServerPfadname ";
  	$SQLCommand.="from Newsletter ";
  	$SQLCommand.="Where (ID=".$_GET['DowID'].")";
  	$SQLResult=mysql_query($SQLCommand,$verbindung);
  	$row = mysql_fetch_object($SQLResult);
  	
  	header("Content-Type: application/force-download");
  	header("Content-Disposition: attachment; filename=".$row->Dateiname);
  	header("Content-type:application/pdf");

  	ob_clean();
  	flush();
  	readfile('./News/'.$row->ServerPfadname);
  	
  	
  }
  
  if (isset($_GET['DelID']))
  {
  	$SQLCommand="Select ID,Bezeichnung,Dateiname,ServerPfadname ";
  	$SQLCommand.="from Newsletter ";
  	$SQLCommand.="Where (ID=".$_GET['DelID'].")";
  	$SQLResult=mysql_query($SQLCommand,$verbindung);
  	$row = mysql_fetch_object($SQLResult);
  	
  	unlink('.\\News\\'.$row->ServerPfadname);
  	$DeleteDS="Delete from Newsletter Where (ID=".$_GET['DelID'].")";
  	$SQLResult=mysql_query($DeleteDS,$verbindung);
  }
  
  if (isset($_POST['SaveNews']))
  {
  	if (is_dir("./News") == false)
  		mkdir("./News");

  	$mFilename = uniqid();
  	$mFilename.= ".";
  	$mFilename.= pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

  	if (file_exists("./News/".$mFilename))
  	{
  		echo $_FILES["file"]["name"] . " existiert schon. ";
  		exit;
  	}
  	else
  	{
  		move_uploaded_file($_FILES["file"]["tmp_name"],
  		"./News/".$mFilename);
  	}

  	$ID=1;
  	$sqlcommand="Select coalesce(Max(ID),0) + 1 as ID from Newsletter ";
  	$SQLResult=mysql_query($sqlcommand,$verbindung);
  	$row=mysql_fetch_object($SQLResult);
  	if ($row->ID > 0)
  	{
  		$ID = $row->ID;
  	}

  	$SQLCommand="Insert Into Newsletter (ID,Bezeichnung,Dateiname,ServerPfadname,newsletter_typ) VALUES (";
  	$SQLCommand.=$ID.",'".$_POST['Bezeichnung']."','".$_FILES["file"]["name"]."','".$mFilename."',".$_POST['TypeNews'].")";
  	$SQLResult=mysql_query($SQLCommand,$verbindung);
  	if (!$SQLResult)
  	{
  		echo $SQLCommand."</br>";
  		echo "Infos konnte nicht eingefügt werden";
  		exit;
  	}
 }
  
if (isset($_POST['SaveEditNews']))
{
    $SQLCommand="Update Newsletter ";
    $SQLCommand.= " set Bezeichnung = '".$_POST['Bezeichnung']."', ";
    $SQLCommand.= " newsletter_typ = ".$_POST['TypeNews']." ";
    $SQLCommand.= " Where (ID = ".$_POST['NewsID'].")";
    $SQLResult=mysql_query($SQLCommand,$verbindung);
    if (!$SQLResult)
    {
        echo $SQLCommand."</br>";
        echo "Infos konnte nicht gespeichert werden";
        exit;
    }
}
  
if (isset($_GET['EditDS']))
{
    $ShowNews=0;
    $SQLCommand="Select ID,Bezeichnung,Dateiname,ServerPfadname,coalesce(newsletter_typ,0) as newsletter_typ ";
    $SQLCommand.="from Newsletter ";
    $SQLCommand.="Where (ID=".$_GET['EditDS'].")";
    //echo $SQLCommand;
    $SQLResult=mysql_query($SQLCommand,$verbindung);
    $row = mysql_fetch_object($SQLResult);

    $mHTML.="<h3>Information ".$row->Bezeichnung." bearbeiten</h3>";
    $mHTML.="<fieldset style=\"width:470px\">";
    $mHTML.="<legend>News</legend>";
    $mHTML.="<form action=\"index.php?Type=Infos\" method=\"post\" enctype=\"multipart/form-data\">";
    $mHTML.="<table border=0 cellspacing=0>";
    $mHTML.="<colgroup>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="</colgroup>";

    $mHTML.="<input type=\"hidden\" name=\"NewsID\" size=30 value=\"".$row->ID."\">";
    $mHTML.="<tr>";
    $mHTML.="<td>Bezeichnung:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Bezeichnung\" size=30 value=\"".$row->Bezeichnung."\"></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Typ:</td>";
    $mHTML.="<td>";
    $mHTML.="<select name=\"TypeNews\">";
    $mHTML.="<option value=\"-1\"";
    if ($row->newsletter_typ == 0)
    {
        $mHTML.=" selected ";
    }
    $mHTML.=">Anleitung</option>";
    $mHTML.="<option value=\"0\"";
    if ($row->newsletter_typ == 0)
    {
        $mHTML.=" selected ";
    }
    $mHTML.=">�zi</option>";
    $mHTML.="<option value=\"1\"";
    if ($row->newsletter_typ == 1)
    {
        $mHTML.=" selected ";
    }
    $mHTML.=">Trolley</option>";
    $mHTML.="<option value=\"2\"";
    if ($row->newsletter_typ == 2)
    {
        $mHTML.=" selected ";
    }
    $mHTML.=">Infostand</option>";
    $mHTML.="</select>";
    $mHTML.="</td>";
    $mHTML.="</tr>";

    $mHTML.="</table>";
    $mHTML.="<input type=\"Submit\" name=\"SaveEditNews\" value=\"Speichern\">";
    $mHTML.="</form>";
    $mHTML.="<a href=\"index.php?Type=Infos&DelID=".$row->ID."\">Löschen</a>";
    $mHTML.="</fieldset></br>";
}
  
if (isset($_POST['NewNews']))
{
    $mHTML.="<h3>Neue Information</h3>";
    $mHTML.="<fieldset style=\"width:470px\">";
    $mHTML.="<legend>News</legend>";
    $mHTML.="<form action=\"index.php?Type=Infos\" method=\"post\" enctype=\"multipart/form-data\">";
    $mHTML.="<table border=0 cellspacing=0>";
    $mHTML.="<colgroup>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="<COL WIDTH=150>";
    $mHTML.="</colgroup>";

    $mHTML.="<tr>";
    $mHTML.="<td>Bezeichnung:</td>";
    $mHTML.="<td><input type=\"Text\" name=\"Bezeichnung\" size=30></td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Typ:</td>";
    $mHTML.="<td>";
    $mHTML.="<select name=\"TypeNews\">";
    $mHTML.="<option value=\"-1\">Anleitung</option>";
    $mHTML.="<option value=\"0\" selected>Özi</option>";
    $mHTML.="<option value=\"1\">Trolley</option>";
    $mHTML.="<option value=\"2\">Infostand</option>";
    $mHTML.="</select>";
    $mHTML.="</td>";
    $mHTML.="</tr>";
    $mHTML.="<tr>";
    $mHTML.="<td>Datei:</td>";
    $mHTML.="<td><input type=\"file\" name=\"file\" id=\"file\"></td>";
    $mHTML.="</tr>";
    $mHTML.="</table>";
    $mHTML.="<input type=\"Submit\" name=\"SaveNews\" value=\"Speichern\">";
    $mHTML.="</form></fieldset></br>";
    $ShowNews=0;
}

if ($ShowNews == 1)
{
    $mHTML.="<h3>News</h3>";
    if ($_SESSION['admin'] == 1)
    {
        $mHTML.="<form action=\"index.php?Type=Infos\" method=\"post\">";
        $mHTML.="<input type=\"submit\" name=\"NewNews\" Value=\"Neue Information\">";
        $mHTML.="</form></br>";
    }


    for ($i = -1; $i <= 1; $i++) {

        $mHeader="";
        $mBild="";
        if ($i == -1)
        {
            $mHeader = '<b>' . CONGREGATION_NAME . '</b> - Infos rund um die Website';
            $mBild="New_Anleitung.png";
        }

        if ($i == 0)
        {
            $mHeader="<b>ÖZi</b> - Die News vom öffentlichen Zeugnisgeben";
            $mBild="News_Oezi.png";
        }

        if ($i == 1)
        {
            $mHeader="<b>Trolley</b> - Alle Infos, Merkblätter und Gebiete";
            $mBild="News_Trolley.png";
        }

        if ($i == 2)
        {
            $mHeader="<b>Infostand</b> - Alle Infos, Merkblätter und Gebiete";
            $mBild="News_Infostand.png";
        }


        $mHTML.="<div class=\"NewsHeader\" style=\"margin:10px 25px 20px 10px;color:#5F497A;border-bottom:solid 1px #5F497A;\">";
        $mHTML.=$mHeader;
        $mHTML.="</div>";

        $SQLCommand="Select ID,Bezeichnung,Dateiname,ServerPfadname ";
        $SQLCommand.="from Newsletter ";
        $SQLCommand.=" Where (coalesce(newsletter_typ,0) = ".$i.") ";
        $SQLCommand.=" order by Bezeichnung ";
        if ($i == 0)
            $SQLCommand.=" DESC ";

        $mHTML.="<div class=\"News\">";

        $SQLResult=mysql_query($SQLCommand,$verbindung);
        while($row = mysql_fetch_object($SQLResult))
        {
            $mHTML.="<div class=\"div_NewsItem\">";

            $mHTML.="<div class=\"div_NewsItem_innerleft\">";
            $mHTML.="<a href=\"index.php?Type=Infos&DowID=".$row->ID."\">";
            $mHTML.="<img src=\"images/".$mBild."\" style=\"max-height:70px;\">";
            $mHTML.="</a>";
            $mHTML.="</div>";

            $Link="index.php?Type=Infos&DowID=".$row->ID;
            if ($_SESSION['admin'] == 1)
            {
                $Link="index.php?Type=Infos&EditDS=".$row->ID;
            }

            $mHTML.="<div class=\"div_NewsItem_innerleft\">";
            $mHTML.="<a href=\"".$Link."\"><p>";
            $mHTML.=$row->Bezeichnung;
            $mHTML.="</p></a>";
            $mHTML.="</div>";

            $mHTML.="<div class=\"Div_Clear\"></div>";

            $mHTML.="</div>";
        }
        $mHTML.="<div class=\"Div_Clear\"></div>";
        $mHTML.="</div>";
    }
}

?>