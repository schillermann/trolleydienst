<?php
include 'function.php';
$ShowList=1;

if (isset($_POST['DelTermin'])) {

    $smtp_delete_date = $database_pdo->prepare(
        'DELETE FROM termine
	    WHERE terminnr = :id_schedule'
    );

    $smtp_delete_date->execute(
        array(':id_schedule' => (int)$_GET['DELID'])
    );
}

if (isset($_GET['SubType'])) {
	if ($_GET['SubType'] == 'SetSL') {

        $smtp_update_shift_from_user = $database_pdo->prepare(
            'UPDATE schichten_teilnehmer
		    SET status = 2, isschichtleiter = 1  
		    WHERE terminnr = :id_schedule
		    AND Schichtnr = :id_shift
		    AND teilnehmernr = :id_user'
        );

        $smtp_update_shift_from_user->execute(
            array(
                ':id_schedule' => (int)$_GET['Terminnr'],
                ':id_shift' => (int)$_GET['Schichtnr'],
                ':id_user' => (int)$_GET['Nr']
            )
        );
	}

	if ($_GET['SubType'] == 'SetBack') {

        $smtp_update_shift_from_user = $database_pdo->prepare(
            'UPDATE schichten_teilnehmer
            SET status = 0, isschichtleiter = 0 
            WHERE terminnr = :id_schedule
		    AND Schichtnr = :id_shift
		    AND teilnehmernr = :id_user'
        );

        $smtp_update_shift_from_user->execute(
            array(
                ':id_schedule' => (int)$_GET['Terminnr'],
                ':id_shift' => (int)$_GET['Schichtnr'],
                ':id_user' => (int)$_GET['Nr']
            )
        );
	}

	if ($_GET['SubType'] == 'SetOK') {

        $smtp_update_shift_from_user = $database_pdo->prepare(
            'UPDATE schichten_teilnehmer
		    SET status = 2 
		    WHERE terminnr = :id_schedule
		    AND Schichtnr = :id_shift
		    AND teilnehmernr = :id_user'
        );

        $smtp_update_shift_from_user->execute(
            array(
                ':id_schedule' => (int)$_GET['Terminnr'],
                ':id_shift' => (int)$_GET['Schichtnr'],
                ':id_user' => (int)$_GET['Nr']
            )
        );
	}

	if ($_GET['SubType'] == 'DelUser') {

        $smpt_date_from_user = $database_pdo->prepare(
            'SELECT Teil.vorname, Teil.email, SchichtTeil.status,
		    Schicht.ort, DATE_FORMAT(Schicht.termin_von, "%d.%m.%Y") AS mDatum
		    FROM schichten_teilnehmer SchichtTeil 
		    INNER JOIN teilnehmer Teil 
		    ON SchichtTeil.teilnehmernr = Teil.teilnehmernr 
		    INNER JOIN termine Schicht
		    ON SchichtTeil.terminnr = Schicht.terminnr 
		    WHERE SchichtTeil.terminnr = :id_schedule
		    AND SchichtTeil.Schichtnr = :id_shift
		    AND SchichtTeil.teilnehmernr = :id_user'
        );

        $smpt_date_from_user->execute(
            array(
                ':id_schedule' => (int)$_GET['Terminnr'],
                ':id_shift' => (int)$_GET['Schichtnr'],
                ':id_user' => (int)$_GET['Nr']
            )
        );

        $date_from_user = $smpt_date_from_user->fetch();

		if ($date_from_user['status'] == 2)
		{
			$Body='Hallo ' . $date_from_user['vorname'] . ', <br><br>';
			$Body.='aus organisatorischen Gründen wurde deine Schicht vom ' . $date_from_user['mDatum'] . ' in ' . $date_from_user['ort'] . ' zurückgenommen';
			SendMail($date_from_user['email'], 'Schicht zurückgenommen', $Body);
		}

        $smpt_delete_user_from_shift = $database_pdo->prepare(
            'DELETE FROM schichten_teilnehmer
		    WHERE terminnr = :id_schedule
		    AND	Schichtnr = :id_shift
		    AND teilnehmernr = :id_user'
        );

        $smpt_delete_user_from_shift->execute(
            array(
                ':id_schedule' => (int)$_GET['Terminnr'],
                ':id_shift' => (int)$_GET['Schichtnr'],
                ':id_user' => (int)$_GET['Nr']
            )
        );
	}

	if ($_GET['SubType'] == 'AddUser' && $_POST['NewRegUser'] > 0)
	{
        $smtp_insert_user_to_shift = $database_pdo->prepare(
            'INSERT INTO schichten_teilnehmer
		    (terminnr, schichtnr, teilnehmernr, status, isschichtleiter)
		    VALUES (:id_schedule, :id_shift, :id_user, 2, 0)'
        );

        $smtp_insert_user_to_shift->execute(
            array(
                ':id_schedule' => (int)$_GET['Terminnr'],
                ':id_shift' => (int)$_GET['Schichtnr'],
                ':id_user' => (int)$_POST['NewRegUser']
            )
        );
	}
}

if (isset($_POST['SaveNewDS'])) {
	$a = 0;

	if ($_POST['Terminserie'] != '')
        $TerminSerieBis = filter_datetime($_POST['Terminserie']);

	$mDatumfaellig = '';

	$date_from = filter_datetime($_POST['Datum'], $_POST['von']);
    $date_to = filter_datetime($_POST['Datum'], $_POST['bis']);

	while ($a == 0) {
        $smtp_next_id_schedule = $database_pdo->query(
            'SELECT coalesce(Max(terminnr),0) + 1 AS terminnr
            FROM termine'
        );

        $next_id_schedule = $smtp_next_id_schedule->fetch();

        $smtp_insert_date = $database_pdo->prepare(
            'INSERT INTO termine (terminnr, art, ort, termin_von, termin_bis, sonderschicht)
		    VALUES (:id_schedule, :type_schedule, :place, :date_from, :date_to, :extra_shift)'
        );

        $terminnr = ($next_id_schedule['terminnr'] > 0) ? $next_id_schedule['terminnr'] : 1;
        $extra_shift = (isset($_POST['Sonderschicht'])) ? 1 : 0;

        $smtp_insert_date->execute(
            array(
                ':id_schedule' => $terminnr,
                ':type_schedule' => (int)$_POST['Art'],
                ':place' => filter_var($_POST['ort'], FILTER_SANITIZE_STRING),
                ':date_from' => $date_from->format('Y-m-d H:i:s'),
                ':date_to' => $date_to->format('Y-m-d H:i:s'),
                ':extra_shift' => $extra_shift
            )
        );

		if ($smtp_insert_date->rowCount() != 1)
			exit("Termin konnte nicht gespeichert werden");

		Get_SetSchichten($database_pdo, $terminnr, (int)$_POST['Stundenanzahl']);

		if ($_POST['Terminserie'] != '') {

            if($TerminSerieBis->getTimestamp() < $date_to->getTimestamp())
                $a = 1;

            $date_from->add(new \DateInterval('P7D'));
            $date_to->add(new \DateInterval('P7D'));
		} else {
			$a = 1;
		}
	}
}

if (isset($_POST['SaveEditClient'])) {

	$mDatumfaellig = '';
    $date_from = filter_datetime($_POST['Datum'], $_POST['von']);
    $date_to = filter_datetime($_POST['Datum'], $_POST['bis']);
    $extra_shift = (isset($_POST['Sonderschicht'])) ? 1 : 0;

    $smtp_update_schedule = $database_pdo->prepare(
        'UPDATE termine
	    SET art = :type_schedule, ort = :place, termin_von = :date_from, termin_bis = :date_to, sonderschicht = :extra_shift
	    WHERE terminnr = :id_schedule'
    );

    $smtp_update_schedule->execute(
        array(
            ':type_schedule' => (int)$_POST['Art'],
            ':place' => filter_var($_POST['ort'], FILTER_SANITIZE_STRING),
            ':date_from' => $date_from->format('Y-m-d H:i:s'),
            ':date_to' => $date_to->format('Y-m-d H:i:s'),
            ':extra_shift' => $extra_shift,
            ':id_schedule' => (int)$_GET['ID']
        )
    );

	if ($smtp_update_schedule->rowCount() != 1)
        exit('Termin konnte nicht gespeichert werden');

	Get_SetSchichten($database_pdo, (int)$_GET['ID'], (int)$_POST['Stundenanzahl']);
}

if (isset($_POST['NewDS'])) {
	$ShowList = 0;
	$mHTML .=
        '<h3>Neuer Termin</h3>
	    <form action="index.php?Type=Termine" method="post">
            <table border=0 cellspacing=0>
                <colgroup>
                    <COL WIDTH=150>
                    <COL WIDTH=150>
                </colgroup>
                <tr>
                    <td>Schichtart:</td>
                    <td>
                        <select name="Art">
                            <option value="0">Infostand</option>
                            <option value="1" selected>Trolley</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Ort:</td>
                    <td><input type="text" name="ort" size="30"></td>
                </tr>
                <tr>
                    <td>Datum:</td>
                    <td><input type="date" name="Datum" size="30"></td>
                </tr>
                <tr>
                    <td>von:</td>
                    <td><input type="time" name="von" size="30" value="10:00"></td>
                </tr>
                <tr>
                    <td>bis:</td>
                    <td><input type="time" name="bis" size="30" value="18:00"></td>
                </tr>
                <tr>
                    <td>Sonderschicht:</td>
                    <td><input type="checkbox" name="Sonderschicht" value="Sonderschicht" ></td>
                </tr>
                <tr>
                    <td>Stundenanzahl:</td>
                    <td><input type="number" name="Stundenanzahl" size="30" value="1"></td>
                </tr>
                <tr>
                    <td>Terminserie bis zum:</td>
                    <td><input type="date" name="Terminserie" size="30"></td>
                </tr>
            </table>
            <input type="Submit" name="SaveNewDS" value="Speichern">
        </form></br>';
}


if (isset($_GET['ASKDELID'])) {
	$ShowList=0;

    $smtp_select_date = $database_pdo->prepare(
        'SELECT terminnr , art , ort,
	    DATE_FORMAT(termin_von, "%d.%m.%Y") as mDatum,
	    DATE_FORMAT(termin_von, "%H:%i") as mvon,
	    DATE_FORMAT(termin_bis, "%H:%i") as mbis
	    FROM termine
        WHERE terminnr  = :id_schedule'
    );

    $smtp_select_date->execute(
        array(':id_schedule' => (int)$_GET['ASKDELID'])
    );

	$date = $smtp_select_date->fetch();
	$mHTML .=
        '<h3>Termin löschen</h3>
	    <form action="index.php?Type=Termine&DELID=' . (int)$_GET['ASKDELID'] . '" method="post">
            Möchten Sie den Termin am ' . $date['mDatum'] . ' wirklich löschen?</br>
            <input type="submit" name="DelTermin" value="Ja">
            <input type="submit" name="NotDelTermin" value="Nein">
	    <form>';
}


if (isset($_GET['ID'])) {
	$ShowList=0;

    $sql_id_schedule = array(':id_schedule' => (int)$_GET['ID']);

    $smtp_number_of_shift = $database_pdo->prepare(
        'SELECT COUNT(terminnr) AS number FROM schichten
        WHERE terminnr = :id_schedule'
    );

    $smtp_number_of_shift->execute($sql_id_schedule);
    $shift = $smtp_number_of_shift->fetch();

    $smtp_select_date = $database_pdo->prepare(
        'SELECT terminnr, art, ort, termin_von, termin_bis, coalesce(sonderschicht, 0) AS sonderschicht
	    FROM termine
	    WHERE terminnr = :id_schedule'
    );

    $smtp_select_date->execute($sql_id_schedule);

	$date = $smtp_select_date->fetch();

    $select_literature_table = ($date['art'] == 0) ? 'selected' : '';
    $select_literature_cart = ($date['art'] == 1) ? 'selected' : '';
    $extra_shift = ($date['sonderschicht'] == 1) ? 'checked' : '';

    $date_from = new DateTime($date['termin_von']);
    $date_to = new DateTime($date['termin_bis']);
    $date_diff = date_diff($date_from, $date_to);
    $shift_hours = $date_diff->format('%h') / $shift['number'];

	$mHTML .=
        '<h3>Termin bearbeiten</h3>
	    <form action="index.php?Type=Termine&ID=' . (int)$_GET['ID'] . '" method="post">
	        <table border=0 cellspacing=0>
	            <colgroup>
                    <COL WIDTH=150>
                    <COL WIDTH=150>
                </colgroup>
                <tr>
                    <td>Schichtart:</td>
                    <td>
                        <select name="Art">
                            <option value="0" ' . $select_literature_table . '>Infostand</option>
                            <option value="1" ' . $select_literature_cart . '>Trolley</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Ort:</td>
                    <td><input type="text" name="ort" size="30" value="' . $date['ort'] . '"></td>
                </tr>
                <tr>
                    <td>Datum:</td>
                    <td><input type="date" name="Datum" size="30" value="' . $date_from->format('Y-m-d') . '"></td>
                </tr>
                <tr>
                    <td>von:</td>
                    <td><input type="time" name="von" size="30" value="' . $date_from->format('H:i') . '"></td>
                </tr>
                <tr>
                    <td>bis:</td>
                    <td><input type="time" name="bis" size="30" value="' . $date_to->format('H:i') . '"></td>
                </tr>
                <tr>
                    <td>Stundenanzahl:</td>
                    <td><input type="number" name="Stundenanzahl" size="30" value="' . $shift_hours . '"></td>
                </tr>
                <tr>
                    <td>Sonderschicht:</td>
                    <td><input type="checkbox" name="Sonderschicht" value="Sonderschicht" '. $extra_shift .'></td>
	            </tr>
	        </table>
	        <input type="Submit" name="SaveEditClient" value="Speichern">
	    </form></br>';
}

if ($ShowList==1) {

	if (!isset($_SESSION['AdminFilterDays']))
		$_SESSION['AdminFilterDays'] = 0;

	if (isset($_POST['FilterTerminTage']))
		$_SESSION['AdminFilterDays'] = (int)$_POST['FilterTerminTage'];

	$InfostandUser = GetUserLookup($database_pdo, 0);
	$TrolleyUser = GetUserLookup($database_pdo, 1);

	$mHTML .=
        '<h3>Termine</h3>
	    <form action="index.php?Type=Termine" method="POST">
	        <table border=0>
	            <tr>
	                <td>
	                    Termine der letzten
	                    <input type="text" name="FilterTerminTage" value="' . (int)$_SESSION['AdminFilterDays'] . '" size="3">
                        Tage anzeigen
                        <input type="submit" name="Refresh" value="Aktualisieren">
                    </td>
	            </tr>
	        </table>
	     <form>
	    </br>
	    <form action="index.php?Type=Termine" method="POST">
	        <input type="submit" name="NewDS" value="Neuen Termin">
	    </form>
	    </br>
	    <div class="div_Legende">
	        <table border=0>
	            <colgroup>
                    <COL WIDTH=60>
                    <COL WIDTH=20>
                    <COL WIDTH=60>
                    <COL WIDTH=20>
                    <COL WIDTH=60>
                    <COL WIDTH=20>
                    <COL WIDTH=60>
                </colgroup>
	            <tr>
	                <td class="Legende">Legende:</td>
                    <td class="Teilnehmer_Status0_Legende">??</td>
                    <td class="Legende">beworben</td>
                    <td class="Teilnehmer_Status2_Legende"></td>
                    <td class="Legende">bestätigt</td>
                    <td class="Teilnehmer_Schichtleiter_Legende">SL</td>
                    <td class="Legende">Schichtleiter</td>
	            </tr>
	        </table>
	    </div>';

    $smtp_select_data_of_shift = $database_pdo->prepare(
        'SELECT terminnr, art, ort,
	    DATE_FORMAT(termin_von, "%d.%m.%Y") AS mDatum,
	    DATE_FORMAT(termin_von, "%w") AS mWochentag,
	    DATE_FORMAT(termin_von, "%H:%i") AS mVon,
	    DATE_FORMAT(termin_bis, "%H:%i") AS mBis,
	    coalesce(sonderschicht, 0) AS sonderschicht
	    FROM termine
	    WHERE datediff(curdate(), termin_von) <= :admin_filter_days
	    ORDER BY termin_von ASC'
    );

    $smtp_select_data_of_shift->execute(
        array(':admin_filter_days' => (int)$_SESSION['AdminFilterDays'])
    );

	while($date_of_shift = $smtp_select_data_of_shift->fetch()) {
		$zusText = '';

		if ($date_of_shift['sonderschicht']) {
			$Farbe = '#D99694';
			$zusText = 'Sonderschicht ';
		} else {
		  if ($date_of_shift['art'] == 0) {
			$Farbe = '#FFC000';
		  } else {
			$Farbe = '#8B72AA';
			$Farbe = '#B3A2C7';
		  }
		}

		$header_date = Get_Wochentag($date_of_shift['mWochentag']).', ' . $date_of_shift['mDatum'];

        if ($date_of_shift['art'] == 0) {
            $header_title = $zusText . 'Infostand:';
            $mType = 0;
        } else {
            $header_title = $zusText . 'Trolley:';
            $mType = 1;
        }


		$mHTML .=
            '<div class="div_Schicht" style="background-color:' . $Farbe . '">
		    <div class="div_Schicht_Header">
		    <div class="div_Schicht_Header_left"><a name="' . $date_of_shift['terminnr'] . '"></a>' . $header_date . '</div>
		    <div class="div_Schicht_Header_right">
		    <b>' . $header_title . '</b>' .
            $date_of_shift['ort'] . '<a href="index.php?Type=Termine&ID=' . $date_of_shift['terminnr'] . '">
            <img src="images/edit.png" style="max-width:22px;max-height:22px;"></a>
		    <a href="index.php?Type=Termine&ASKDELID=' . $date_of_shift['terminnr'] . '">
            <img src="images/Nein.png" style="max-width:22px;max-height:22px;"></a>
		    </div>
		    </div>
		    <div class="div_Schichtrows">';

        $smtp_select_shift_list = $database_pdo->prepare(
            'SELECT terminnr, von, bis, Schichtnr,
		    DATE_FORMAT(von, "%H:%i") AS Zeitvon,
		    DATE_FORMAT(bis, "%H:%i") AS Zeitbis
		    FROM schichten
		    WHERE terminnr= :id_schedule
		    ORDER BY Schichtnr'
        );

        $smtp_select_shift_list->execute(
            array(':id_schedule' => (int)$date_of_shift['terminnr'])
        );

		while($shift_list = $smtp_select_shift_list->fetch()) {

            $smpt_select_number_of_user_from_shift = $database_pdo->prepare(
                'SELECT count(*) AS Anz
			    FROM schichten_teilnehmer SchTeil
			    WHERE SchTeil.terminnr = :id_schedule
			    AND SchTeil.schichtnr = :id_shift
			    AND SchTeil.isschichtleiter = 1'
            );

            $smpt_select_number_of_user_from_shift->execute(
                array(
                    ':id_schedule' => (int)$date_of_shift['terminnr'],
                    ':id_shift' => (int)$shift_list['Schichtnr']
                )
            );

			$number_of_user_from_shift = $smpt_select_number_of_user_from_shift->fetch();
			$mAnzSchichtleiter = $number_of_user_from_shift['Anz'];

			$mHTML .=
                '<div class="div_Schicht_Time">' . $shift_list['Zeitvon'] . ' - ' . $shift_list['Zeitbis'] . '</div>
			    <div class="div_Schicht_Teilnehmer"><table><tr>';
            $mAnzTD=0;
			$AllowApply=1;
			$mAnzAktiv=0;

            $smtp_select_user_from_date = $database_pdo->prepare(
                'SELECT SchTeil.teilnehmernr, SchTeil.status, SchTeil.isschichtleiter,
			    muser.vorname AS vorname, muser.nachname AS nachname,
			    muser.versammlung, muser.sprache, muser.infostand, muser.trolley,
			    coalesce(muser.Bemerkung, "") AS UserBemerkung,
			    coalesce(muser.MaxSchichten, 2) AS MaxSchichten,
			    coalesce(muser.TeilnehmerBemerkung, "") AS TeilnehmerBemerkung
			    FROM schichten_teilnehmer SchTeil
			    LEFT OUTER JOIN teilnehmer muser
			    ON SchTeil.teilnehmernr = muser.teilnehmernr
			    WHERE SchTeil.terminnr = :id_schedule
			    AND SchTeil.schichtnr = :id_shift'
            );

            $smtp_select_user_from_date->execute(
                array(
                    ':id_schedule' => (int)$date_of_shift['terminnr'],
                    ':id_shift' => (int)$shift_list['Schichtnr']
                )
            );

			while($user_from_date = $smtp_select_user_from_date->fetch()) {
				$AddSchulung='';
				if ($date_of_shift['art'] == 0)
					if ($user_from_date['infostand'] == 2)
						$AddSchulung='Schulung, ';
				else
					if ($user_from_date['trolley'] == 2)
						$AddSchulung='Schulung, ';

				$mAnzTD = $mAnzTD + 1;

				if ($mAnzTD > 0) {
					$mHTML .= '</tr><tr>';
					$mAnzTD = 0;
				}

				if ($user_from_date['status'] == 0)
					$class = 'Teilnehmer_Status0';

				if ($user_from_date['status'] == 2) {
					$mAnzAktiv = $mAnzAktiv + 1;
					if ($user_from_date['isschichtleiter'] == 1)
						$class = 'Teilnehmer_Schichtleiter';
					else
						$class = 'Teilnehmer_Status2';
				}
				$mHTML .=
                    '<td class="' . $class. ' td_Teilnehmer" style="position:relative;">' . $user_from_date['vorname'] .
                    ' ' . $user_from_date['nachname'] . ' (' . $AddSchulung . $user_from_date['versammlung'] . ')';

				if ($user_from_date['status'] == 0)
					$mHTML .=
                        '<a href="index.php?Type=Termine&SubType=SetOK&Terminnr=' .
                        $date_of_shift['terminnr'] . "&Schichtnr=" . $shift_list['Schichtnr'] .
                        '&Nr=' . $user_from_date['teilnehmernr'] . '#' . $date_of_shift['terminnr'] . '">
                        <img src="images/Ja.png" style="max-width:22px;max-height:22px;"></a>';
				else
					$mHTML .=
                        '<a href="index.php?Type=Termine&SubType=SetBack&Terminnr=' . $date_of_shift['terminnr'] .
                        '&Schichtnr=' . $shift_list['Schichtnr'] . '&Nr=' . $user_from_date['teilnehmernr'] . '#' .
                        $date_of_shift['terminnr'] . '">
                        <img src="images/goback.png" style="max-width:22px;max-height:22px;"></a>';

				if ($mAnzSchichtleiter == 0)
				  $mHTML .=
                      '<a href="index.php?Type=Termine&SubType=SetSL&Terminnr=' .
                      $date_of_shift['terminnr'] . '&Schichtnr=' . $shift_list['Schichtnr'] . '&Nr=' .
                      $user_from_date['teilnehmernr'] . '#' . $date_of_shift['terminnr'] . '">
                      <img src="images/SL.png" style="max-width:22px;max-height:22px;"></a>';

				$mHTML .=
                    '<a href="index.php?Type=Termine&SubType=DelUser&Terminnr=' . $date_of_shift['terminnr'] .
                    '&Schichtnr=' . $shift_list['Schichtnr'] . '&Nr=' . $user_from_date['teilnehmernr'] .
                    '#' . $date_of_shift['terminnr'] . '">
                    <img src="images/Nein.png" style="max-width:22px;max-height:22px;"></a>';

				$BemerkungsText="";
				if ($user_from_date['MaxSchichten'] != '')
					$BemerkungsText .= '<b>Stunden/Tag:</b>' . $user_from_date['MaxSchichten'] . '<br>';

				if ($user_from_date['TeilnehmerBemerkung'] != '')
					$BemerkungsText .= '<b>Bemerkung:</b><br>' . $user_from_date['TeilnehmerBemerkung'] . '<br>';

				if ($user_from_date['UserBemerkung'] != '')
					$BemerkungsText .= '<b>interne Bemerkung:</b><br>' . $user_from_date['UserBemerkung'] . '<br>';

				if ($BemerkungsText != '')
					$mHTML .= '<div class="arrow_box">' . $BemerkungsText . '</div>';

				$mHTML .= '</td>';
			}

			$mHTML .=
                '</tr><tr><td>
                <form action="index.php?Type=Termine&SubType=AddUser&Terminnr=' . $date_of_shift['terminnr'] .
                '&Schichtnr=' . $shift_list['Schichtnr'] . '#' . $date_of_shift['terminnr'] . '" method="POST">';

			if ($mType == 0)
				$mHTML .= '<select name="NewRegUser">' . $InfostandUser . '</select>';
			else
				$mHTML .= '<select name="NewRegUser">' . $TrolleyUser . '</select>';

			$mHTML .= '<input type="submit" name="AddSchichtuser" value="Hinzufügen"></form></td>';

			if ($mAnzSchichtleiter == 0)
				if ($mAnzAktiv >= 2)
					if ($date_of_shift['art'] == 0)
						$mHTML .= '<td><font color="red">Schichtleiter fehlt</td>';

			$mHTML .= '</tr></table></div><div class="Div_Clear"></div>';
		}

		$mHTML .= '</div><div class="div_Schicht_Footer"></div></div>';
	}

	$mHTML .=
        '<script type="text/javascript">
	        $(".td_Teilnehmer").hover(function(){ 
	            $(this).find(".arrow_box").show(); 
	        });
	        $(".td_Teilnehmer a").hover(function(){
	            $(this).parent().find(".arrow_box").show();
	        });
	        $(".td_Teilnehmer").mouseout(function () {
	            $(this).find(".arrow_box").hide();
	        });
	        $(".arrow_box").hover(function(){
	            $(this).show();
	        });
	        $(".arrow_box").mouseout(function () {
	            $(this).hide();
	        });
	    </script>';
}
?>