<?php
$ShowList=1;
include "function.php";

if (isset($_POST['DelSchichtTeil'])) {


    $stmt_shift_list = $database_pdo->prepare(
        'SELECT sch.terminnr, sch.von, sch.bis, sch.Schichtnr,
        DATE_FORMAT(sch.von, "%d.%m.%Y") AS mDatum,
        DATE_FORMAT(sch.von, "%H:%i") AS Zeitvon,
        DATE_FORMAT(sch.bis, "%H:%i") AS Zeitbis,
        coalesce(mUser.vorname,"") AS vorname,
        coalesce(mUser.nachname,"") AS nachname
        FROM schichten sch INNER JOIN schichten_teilnehmer mTeil
        ON sch.terminnr = mTeil.terminnr AND
        sch.Schichtnr = mTeil.Schichtnr
        INNER JOIN teilnehmer mUser
        ON mTeil.teilnehmernr = mUser.teilnehmernr
        WHERE (sch.terminnr = :id_schedule) AND
        (sch.Schichtnr = :id_shift) AND
        (mTeil.teilnehmernr = :id_user) AND
        (mTeil.status = 2) 
        ORDER BY sch.Schichtnr '
    );

    $stmt_shift_list->execute(
        array(
            ':id_schedule' => (int)$_POST['Terminnr'],
            ':id_shift' => (int)$_POST['Schichtnr'],
            ':id_user' => $_SESSION['ID']
        )
    );

    while($shift = $stmt_shift_list->fetch()) {
        $mMessage = 'Liebes ÖZ-Organisationsteam, <br><br>';
        $mMessage .= 'folgende Schicht wurde zurückgewiesen: <br>';
        $mMessage .= 'Datum: ' . $shift['mDatum'] . ' ' . $shift['Zeitvon'] . '-' . $shift['Zeitbis'] . '<br>';
        $mMessage .= 'Von: ' . $shift['vorname'] . ' ' . $shift['nachname'] . '<br>';
        SendMail(EMAIL_ADDRESS, 'Schicht zurückgewiesen' , $mMessage);
    }

    $stmt_delete_user_from_shift = $database_pdo->prepare(
        'DELETE FROM schichten_teilnehmer 
        WHERE terminnr = :id_schedule
        AND Schichtnr = :id_shift
        AND teilnehmernr = :id_user'
    );

    $stmt_delete_user_from_shift->execute(
        array(
            ':id_schedule' => (int)$_POST['Terminnr'],
            ':id_shift' => (int)$_POST['Schichtnr'],
            ':id_user' => (int)$_SESSION['ID']
        )
    );
}

if (isset($_GET['SubType']))
{
    if ($_GET['SubType'] == 'DelUser')
    {
        $ShowList = 0;

        $stmt_shift = $database_pdo->prepare(
            'SELECT sch.terminnr, sch.von, sch.bis, sch.Schichtnr,
            DATE_FORMAT(sch.von, "%d.%m.%Y") as mDatum, 
            DATE_FORMAT(sch.von, "%H:%i") as Zeitvon,
            DATE_FORMAT(sch.bis, "%H:%i") as Zeitbis
            FROM schichten sch  
            WHERE sch.terminnr= :id_schedule
            AND sch.Schichtnr = :id_shift
            ORDER BY sch.Schichtnr'
        );

        $stmt_shift->execute(
            array(
                ':id_schedule' => (int)$_GET['Terminnr'],
                ':id_shift' => (int)$_GET['Schichtnr']
            )
        );
        $shift = $stmt_shift->fetch();

        $mHTML .=
            '<div class="div_Warning">
                <form action="index.php?Type=Schichten" method="post">
                    Möchtest du die Schicht am ' . $shift['mDatum'] . ' vom ' . $shift['Zeitvon'] . '
                    bis ' . $shift['Zeitbis'] . ' zurückweisen?</br></br>
                    <input type="hidden" name="Terminnr" value="' . (int)$_GET['Terminnr'] . '">
                    <input type="hidden" name="Schichtnr" value="' . (int)$_GET['Schichtnr'] . '">
                    <input type="submit" name="DelSchichtTeil" Value="Ja">
                    <input type="submit" name="GoBack" Value="Nein">
                </form>
            </div>';
    }
}

if (isset($_POST['SetSchicht'])) {
    $stmt_add_user_to_shift = $database_pdo->prepare(
        'INSERT INTO schichten_teilnehmer
        (terminnr, schichtnr, teilnehmernr, status, isschichtleiter)
        VALUES (:id_schedule, :id_shift, :id_user, 0, 0)'
    );

    $stmt_add_user_to_shift->execute(
        array(
            ':id_schedule' => (int)$_POST['Terminnr'],
            ':id_shift' => (int)$_POST['Schichtnr'],
            ':id_user' => (int)$_SESSION['ID']
        )
    );
}

if ($ShowList == 1)
{
    $stmt_settings_schedule_max_days = $database_pdo->prepare(
        'SELECT FilterTerminTage FROM settings'
    );

    $stmt_settings_schedule_max_days->execute();
    $settings = $stmt_settings_schedule_max_days->fetch();

    $mTageFilter = (int)$settings['FilterTerminTage'];

    $mHTML.=
        '<h3 class="Title_Middle">Schichten</h3>
        <div class="div_Legende">
            <table>
                <colgroup>
                    <COL width="60">
                    <COL width="20">
                    <COL width="60">
                    <COL width="20">
                    <COL width="60">
                    <COL width="20">
                    <COL width="60">
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

    $AllowSchichtArt = array(-1);

    if ($_SESSION['infostand'] == 1)
        $AllowSchichtArt[] = 0;
    if ($_SESSION['trolley'] == 1)
        $AllowSchichtArt[] = 1;

    $stmt_schedule = $database_pdo->prepare(
        'SELECT terminnr, art, ort,
        DATE_FORMAT(termin_von, "%d.%m.%Y") as mDatum,
        DATE_FORMAT(termin_von, "%w") as mWochentag,
        DATE_FORMAT(termin_von, "%H:%i") as mVon,
        DATE_FORMAT(termin_bis, "%H:%i") as mBis,
        DATEDIFF(termin_von,curdate()) AS DiffDate,
        coalesce(sonderschicht,0) as sonderschicht
        FROM termine
        WHERE art IN(' . implode(',', $AllowSchichtArt) . ')
        AND (datediff(curdate(),termin_von) <= :schedule_max_days )
        ORDER BY termin_von ASC'
    );

    $stmt_schedule->execute(
        array(':schedule_max_days' => (int)$mTageFilter)
    );

    while($schedule = $stmt_schedule->fetch()) {
        $zusText="";
        if ($schedule['sonderschicht']) {
            $Farbe='#D99694';
            $zusText="Sonderschicht ";
        } else {
            if ($schedule['art'] == 0)
                $Farbe='#FFC000';
            else
                $Farbe='#B3A2C7';
        }

        $mHTML.=
            '<div class="div_Schicht" style="background-color:' . $Farbe . '">
            <div class="div_Schicht_Header">
            <div class="div_Schicht_Header_left">
            <a name="' . $schedule['terminnr'] . '"></a>
            ' . Get_Wochentag($schedule['mWochentag']) . ', ' . $schedule['mDatum'] . '
            </div>
            <div class="div_Schicht_Header_right">';

        if ($schedule['art'] == 0)
            $mHTML .= '<b>' . $zusText . 'Infostand:</b>';
        else
            $mHTML .= '<b>' . $zusText . 'Trolley:</b>';

        $mOrt = strtoupper($schedule['ort']);
        $mHTML.=$mOrt;
        $mHTML.= '</div></div><div class="div_Schichtrows">';

        $stmt_shifts = $database_pdo->prepare(
            'SELECT sch.terminnr, sch.von, sch.bis, sch.Schichtnr,
            DATE_FORMAT(sch.von, "%H:%i") as Zeitvon,
            DATE_FORMAT(sch.bis, "%H:%i") as Zeitbis
            FROM schichten sch
            WHERE sch.terminnr = :id_schedule
            ORDER BY sch.Schichtnr'
        );

        $stmt_shifts->execute(
            array(
                ':id_schedule' => (int)$schedule['terminnr']
            )
        );

        while($shift = $stmt_shifts->fetch()) {
            $mHTML .=
                '<div class="div_Schicht_Time">' . $shift['Zeitvon'] . ' - ' . $shift['Zeitbis'] . '</div>
                <div class="div_Schicht_Teilnehmer"><table><tr>';

            $mAnzTD=0;
            $AllowApply=1;

            $stmt_users_from_shift = $database_pdo->prepare(
                'SELECT SchTeil.teilnehmernr, SchTeil.status, SchTeil.isschichtleiter,
                muser.vorname AS vorname, muser.nachname AS nachname,
                muser.Handy AS mobil
                FROM schichten_teilnehmer SchTeil
                LEFT OUTER JOIN teilnehmer muser
                ON SchTeil.teilnehmernr = muser.teilnehmernr
                WHERE SchTeil.terminnr = :id_schedule
                AND SchTeil.schichtnr = :id_shift
                ORDER BY SchTeil.isschichtleiter DESC '
            );

            $stmt_users_from_shift->execute(
                array(
                    ':id_schedule' => (int)$shift['terminnr'],
                    ':id_shift' => (int)$shift['Schichtnr']
                )
            );

            while($user_from_shift = $stmt_users_from_shift->fetch()) {
                if ($user_from_shift['teilnehmernr'] == $_SESSION['ID']) {
                    $AllowApply=0;
                    if ($user_from_shift['status'] == 0)
                        $class="Teilnehmer_Status0";

                    if ($user_from_shift['status'] == 2)
                        if ($user_from_shift['isschichtleiter'] == 1)
                            $class="Teilnehmer_Schichtleiter";
                        else
                            $class="Teilnehmer_Status2";

                    $mAnzTD = $mAnzTD + 1;
                    $mHTML .=
                        '<td class="' . $class . '">' . $user_from_shift['vorname'] . ' ' . $user_from_shift['nachname'];

                    if (($schedule['DiffDate'] > 3) || ($user_from_shift['status'] == 0))
                        $mHTML .=
                            '<a href="index.php?Type=Schichten&SubType=DelUser&Terminnr=' . $shift['terminnr'] .
                            '&Schichtnr=' . $shift['Schichtnr'] . "#" . $shift['terminnr'] . '">' .
                            '<img src="images/Nein.png" style="max-width:22px;max-height:22px;"></a>';

                    $mHTML .= '</td>';
                } else {
                    if ($user_from_shift['status'] == 2) {
                        if ($user_from_shift['isschichtleiter'] == 1)
                            $mHTML .= '<td class="otherTeilnehmer_Schichtleiter">';
                        else
                            $mHTML .= '<td class="otherTeilnehmer">';

                        $mAnzTD = $mAnzTD + 1;
                        if(empty($user_from_shift['mobil']))
                            $mHTML .=  $user_from_shift['vorname'] . " " . $user_from_shift['nachname'] . '</td>';
                        else
                            $mHTML .=
                                '<a href="tel:' . $user_from_shift['mobil'] . '">' .
                                $user_from_shift['vorname'] . " " . $user_from_shift['nachname'] . '</a></td>';
                    }
                }
            }

            if ($mAnzTD >= 2)
                $AllowApply = 0;

            if ($AllowApply == 1) {
                $mAnzTD = $mAnzTD + 1;
                $mHTML .=
                    '<td  class="otherTeilnehmer">
                        <form action="index.php?Type=Schichten#' . $schedule['terminnr'] . '" method="post">
                            <input type="hidden" name="Terminnr" value="' . $schedule['terminnr'] . '">
                            <input type="hidden" name="Schichtnr" value="' . $shift['Schichtnr'] . '">
                            <input type="submit" name="SetSchicht" value="bewerben">
                        </form>
                    </td>';
            }
            $mHTML .= '</tr></table></div><div class="Div_Clear"></div>';
        }

        $mHTML .= '</div><div class="div_Schicht_Footer"></div></div>';
    }
}
?>