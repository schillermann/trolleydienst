<?php
function Get_Wochentag(int $Wochentagnr) : string {
	$mWochentagname = '';
	if ($Wochentagnr == 0)
		$mWochentagname = 'Sonntag';
	if ($Wochentagnr == 1)
		$mWochentagname = 'Montag';
	if ($Wochentagnr == 2)
		$mWochentagname = 'Dienstag';
	if ($Wochentagnr == 3)
		$mWochentagname = 'Mittwoch';
	if ($Wochentagnr == 4)
		$mWochentagname = 'Donnerstag';
	if ($Wochentagnr == 5)
		$mWochentagname = 'Freitag';
	if ($Wochentagnr == 6)
		$mWochentagname = 'Samstag';

	return $mWochentagname;
}

function Get_SetSchichten(PDO $database_pdo, int $Terminnr, int $AnzStunden) {

	if ($AnzStunden < 1)
		$AnzStunden = 1;

    $stmt_select_date = $database_pdo->prepare(
        'SELECT terminnr ,
	    DATE_FORMAT(termin_von, "%Y-%m-%d") AS mDatum, 
	    DATE_FORMAT(termin_von, "%H:%i") AS von,
	    DATE_FORMAT(termin_bis, "%H") AS bis,
	    DATE_FORMAT(termin_bis, "%i") AS bis_minuten
	    FROM termine
	    WHERE terminnr  = :id_schedule'
    );

    $stmt_select_date->execute(
        array(':id_schedule' => (int)$Terminnr)
    );

    $date = $stmt_select_date->fetch();

	$Schicht_von = $date['von'];

	$Schichtnr = 0;
	$mDebug=0;
    while (($Schicht_von < $date['bis']) && ($mDebug < 5000)) {

		$mDebug++;
    	$Schichtzeit_von = $date['mDatum'] . ' ' . $Schicht_von . ':00';
    	$Schicht_bis = $Schicht_von + $AnzStunden;
    	$Schichtzeit_bis = $date['mDatum'] . ' ' . $Schicht_bis;

    	if ($Schicht_bis == $date['bis'])
    		$Schichtzeit_bis .= ':' . $date['bis_minuten'];
    	else
    		$Schichtzeit_bis .= ':00';

    	$Schichtnr = $Schichtnr + 1;

        $smtp_number_of_shifts = $database_pdo->prepare(
            'SELECT COUNT(*) AS Anz FROM schichten
    	    WHERE terminnr = :id_schedule
    	    AND Schichtnr = :id_shift'
        );

        $smtp_number_of_shifts->execute(
            array(
                ':id_schedule' => (int)$Terminnr,
                ':id_shift' => (int)$Schichtnr
            )
        );

        $number_of_shifts = $smtp_number_of_shifts->fetch();

        $edit_shift_values = array(
            ':id_schedule' => (int)$Terminnr,
            ':shift_from' => $Schichtzeit_von,
            ':shift_to' => $Schichtzeit_bis,
            ':id_shift' => (int)$Schichtnr
        );

    	if ($number_of_shifts['Anz'] > 0) {

            $smtp_update_shift = $database_pdo->prepare(
                'UPDATE schichten
    		    SET von = :shift_from, bis = :shift_to 		
    		    WHERE terminnr = :id_schedule
    		    AND Schichtnr = :id_shift'
            );

            $smtp_update_shift->execute($edit_shift_values);
    	} else {

            $smtp_insert_shift = $database_pdo->prepare(
                'INSERT INTO schichten
    		    (terminnr, status, von, bis, Schichtnr, status_1, status_2, status_3)
    		    VALUES (:id_schedule, 0 , :shift_from, :shift_to, :id_shift, 0, 0, 0)'
            );

            $smtp_insert_shift->execute($edit_shift_values);
    	}
    	$Schicht_von = $Schicht_von + $AnzStunden;
    }

    $smtp_delete_shift = $database_pdo->prepare(
        'DELETE FROM schichten
        WHERE terminnr = :id_schedule
        AND Schichtnr > :id_shift'
    );

    $smtp_delete_shift->execute(
        array(
            ':id_schedule' => (int)$Terminnr,
            ':id_shift' => (int)$Schichtnr
        )
    );
	
	return 1;
}

function GetUserLookup(PDO $database_pdo, int $mType) : string {

    $sql_where = ($mType == 0) ? 'infostand' : 'trolley';
	$sql_select_user_list =
        'SELECT teilnehmernr, status, vorname, nachname, email, username,
        infostand, trolley, admin, Handy, Telefonnr, versammlung, sprache
        FROM teilnehmer 
        WHERE ' . $sql_where . ' <> 0';

    $smtp_user_list = $database_pdo->query($sql_select_user_list);

    $ResultComboBox = '<option value="-1" selected></option>';

 	while ($user_data = $smtp_user_list->fetch())
 		$ResultComboBox .=
            '<option value="' . $user_data['teilnehmernr'] . '">' . $user_data['vorname'] . ' ' . $user_data['nachname'] . '</option>';

	return $ResultComboBox;
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

function SendMail($to, $subject, $message) {
    $header = 'From: ' . CONGREGATION_NAME . ' <' . EMAIL_FROM_ADDRESS . '>' . "\n";
    $header .= 'Reply-To: Trolley Team <' . EMAIL_REPLY_TO_ADDRESS . '>' . "\n";
    $header .= 'Content-type: text/plain; charset=UTF-8';

    return mail($to, $subject, $message, $header);
}

function filter_datetime(string $date, string $time = null) : \DateTime {

    if($date_format_german = DateTime::createFromFormat('d.m.Y', $date))
        $date_time = $date_format_german;
    elseif ($date_format_america = DateTime::createFromFormat('Y-m-d', $date))
        $date_time = $date_format_america;
    else
        $date_time = new \DateTime($date);

    if($time) {
        $hours_minutes = explode(':', $time);
        $date_time->setTime($hours_minutes[0], $hours_minutes[1]);
    }

    return $date_time;
}
?>