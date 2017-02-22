<?php
function Get_Wochentag($Wochentagnr)
{
	$mWochentagname="";
	if ($Wochentagnr == 0)
	{
		$mWochentagname = 'Sonntag';
	}
	if ($Wochentagnr == 1)
	{
		$mWochentagname = 'Montag';
	}
	if ($Wochentagnr == 2)
	{
		$mWochentagname = 'Dienstag';
	}
	if ($Wochentagnr == 3)
	{
		$mWochentagname = 'Mittwoch';
	}
	if ($Wochentagnr == 4)
	{
		$mWochentagname = 'Donnerstag';
	}
	if ($Wochentagnr == 5)
	{
		$mWochentagname = 'Freitag';
	}
	if ($Wochentagnr == 6)
	{
		$mWochentagname = 'Samstag';
	}

	return $mWochentagname;
}

function Get_SetSchichten($Terminnr,$AnzStunden)
{
	include "DBConnect.php";
	if ($AnzStunden == '')
		$AnzStunden = 1;
	if ($AnzStunden < 1)
		$AnzStunden = 1;

	$SQLCommand="Select terminnr , ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%Y-%m-%d') as mDatum, ";
	$SQLCommand.="DATE_FORMAT(termin_von, '%H') as von, ";
	$SQLCommand.="DATE_FORMAT(termin_bis, '%H') as bis, ";
	$SQLCommand.="DATE_FORMAT(termin_bis, '%i') as bis_minuten ";
	$SQLCommand.="from termine ";
	$SQLCommand.="Where (terminnr  = ".$Terminnr.")";

	$SQLResult=mysql_query($SQLCommand,$verbindung);
	$row = mysql_fetch_object($SQLResult);
	$Schicht_von = $row->von;

	$Schichtnr = 0;
	$mDebug=0;
    while (($Schicht_von < $row->bis) && ($mDebug < 5000))
    {
		$mDebug++;
    	$Schichtzeit_von=$row->mDatum." ".$Schicht_von.":00";
    	$Schicht_bis = $Schicht_von + $AnzStunden;
    	$Schichtzeit_bis=$row->mDatum." ".$Schicht_bis;
    	if ($Schicht_bis == $row->bis)
    	{
    		$Schichtzeit_bis.=":".$row->bis_minuten;
    	}
    	else
    	{
    		$Schichtzeit_bis.=":00";
    	}

    	$Schichtnr = $Schichtnr + 1;
    	$SQLCommandSchichten="Select count(*) as Anz FROM schichten ";
    	$SQLCommandSchichten.="Where (terminnr = ".$Terminnr.") and (Schichtnr=".$Schichtnr.")";
    	$SQLResultSchichten=mysql_query($SQLCommandSchichten,$verbindung);
    	$rowSchichten = mysql_fetch_object($SQLResultSchichten);
    	if ($rowSchichten->Anz > 0)
    	{
    		$UpdateCommand="Update schichten ";
    		$UpdateCommand.="set ";
    		$UpdateCommand.="von='".$Schichtzeit_von."', ";
    		$UpdateCommand.="bis='".$Schichtzeit_bis."' ";   		
    		$UpdateCommand.="Where (terminnr = ".$Terminnr.") and ";
    		$UpdateCommand.="(Schichtnr = ".$Schichtnr.") ";
    		$SQLResult=mysql_query($UpdateCommand,$verbindung);
    	}
    	else 
    	{
    		$InsertCommand="Insert Into schichten (";
    		$InsertCommand.="terminnr, status, von, bis, Schichtnr,status_1,status_2,status_3) ";
    		$InsertCommand.="VALUES (";
    		$InsertCommand.=$Terminnr.",0,'".$Schichtzeit_von."','";    		
    		$InsertCommand.=$Schichtzeit_bis."',".$Schichtnr.",0,0,0)";    		
    		$SQLResult=mysql_query($InsertCommand,$verbindung);
    	}
    	$Schicht_von = $Schicht_von + $AnzStunden;
    }
    $SQLCommandSchichten="Delete from schichten ";
    $SQLCommandSchichten.="Where (terminnr = ".$Terminnr.") and (Schichtnr>".$Schichtnr.")";
    $SQLResultSchichten=mysql_query($SQLCommandSchichten,$verbindung);
	
    
	
	return 1;
}

function GetUserLookup($mType)
{
	include "DBConnect.php";
	
	$Filter="";
	if ($mType == 0)
		$Filter= ' (infostand <> 0) ';
	else
		$Filter= ' (trolley <> 0) ';
	
	$ResultComboBox="<option value=\"-1\" selected></option>";
	
	$SQLCommand="Select teilnehmernr, status, vorname, nachname, email , username , infostand, trolley, admin,Handy,Telefonnr,versammlung,sprache ";
    $SQLCommand.="from teilnehmer ";
    $SQLCommand.="Where ".$Filter;   
	$SQLResult=mysql_query($SQLCommand,$verbindung);
 	while ($row = mysql_fetch_object($SQLResult))
 	{
 		$ResultComboBox.="<option value=\"".$row->teilnehmernr."\">".$row->vorname." ".$row->nachname."</option>";
	}
	return $ResultComboBox;
}

function GetFooter()
{
	return 
        '<br><br>'.
        'Deine Brüder <br>'.
        'Organisationsteam <br>'.
        'öffentliches Zeugnisgeben ' . CONGREGATION_NAME . ' <br>'.
        '<a href="' . $_SERVER['SERVER_NAME'] . '">' . $_SERVER['SERVER_NAME'] . '</a><br>'.
        '<a href="mailto:' . EMAIL_ADDRESS . '">' . EMAIL_ADDRESS . '</a><br>';
}

function generateMessageID() 
{ 
   return sprintf( 
     "<%s.%s@%s>", 
     base_convert(microtime(), 10, 36), 
     base_convert(bin2hex(openssl_random_pseudo_bytes(8)), 16, 36), 
     $_SERVER['SERVER_NAME'] 
   ); 
 } 

function SendMail($Empf,$Betreff,$Body)
{
	
	$date= date("r");
	
	$mFooter=GetFooter();
	$MessageID = generateMessageID();
	$date= date("r"); 

    $Mailheaders = 'From: ' . EMAIL_ADDRESS . '<' . EMAIL_ADDRESS . '>' . "\n";
    $Mailheaders .= 'Reply-To: ' . EMAIL_ADDRESS . '<' . EMAIL_ADDRESS . '>' . "\n";
    $Mailheaders .= "Message-ID: ".$MessageID."\n";
    $Mailheaders .= "MIME-Version: 1.0\n";
    $Mailheaders .= "Date: $date\n";
    $Mailheaders .= "Delivered-to: $Empf\n";
    $Mailheaders .= 'Return-Path: ' . EMAIL_ADDRESS . '<' . EMAIL_ADDRESS . '>' . "\n";
    $Mailheaders .= "Content-Type: text/html; charset=UTF-8\n";

	mail($Empf,"=?utf-8?b?".base64_encode($Betreff)."?=","<html>".$Body.$mFooter."</html>",$Mailheaders);
	return '1';
}
?>