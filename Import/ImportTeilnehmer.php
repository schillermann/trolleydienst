
<?php

include "DBConnect.php";

if (isset($_POST['Excelauslesen']))
{
	
	
	$Del="Delete from schichten_teilnehmer ";		
	$SQLResult=mysql_query($Del,$verbindung);
	
	$Del="Delete from teilnehmer Where (username <> 'Admin') ";
	$SQLResult=mysql_query($Del,$verbindung);
	
	if (isset($_POST['Excelauslesen']))
	{
		error_reporting(E_ALL ^ E_NOTICE);
		require_once 'excel_reader2.php';
		$data = new Spreadsheet_Excel_Reader($_FILES["file"]["tmp_name"]);
		echo $data->dump_test2(true,true);
		$ShowView=0;
	}


	exit;
}
$mHTML ="Bitte w&auml;hlen Sie die XLS-Datei f&uuml;r den Kundenimport aus<br>";
$mHTML.="<form action=\"ImportTeilnehmer.php\" method=\"post\" enctype=\"multipart/form-data\">";
$mHTML.="<table>";
$mHTML.="<tr>";
$mHTML.="<td>";
$mHTML.="Datei:";
$mHTML.="</td>";
$mHTML.="<td>";
$mHTML.="<input type=\"file\" name=\"file\" id=\"file\">";
$mHTML.="</td>";
$mHTML.="</tr>";
$mHTML.="<tr>";
$mHTML.="<td>";
$mHTML.="<input type=\"Submit\" name=\"Excelauslesen\" value=\"Import starten\">";
$mHTML.="</td>";
$mHTML.="</tr>";
$mHTML.="</table>";
$mHTML.="</form>";
echo $mHTML;


?>