<?php
session_start();

include "function.php";
$database_pdo = include 'includes/database_pdo.php';

$stmt_settings_schedule_max_days = $database_pdo->prepare(
    'SELECT FilterTerminTage FROM settings'
);

$stmt_settings_schedule_max_days->execute();
$settings = $stmt_settings_schedule_max_days->fetch();

$mTageFilter = (int)$settings['FilterTerminTage'];

$AllowSchichtArt = array(-1);

if ($_SESSION['literature_table'] == 1)
    $AllowSchichtArt[] = 0;
if ($_SESSION['literature_cart'] == 1)
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

$mHTML = '';

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
            if ($user_from_shift['teilnehmernr'] == $_SESSION['id_user']) {
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

$template_placeholder['content'] = $mHTML;
$render_page = include 'includes/page_render.php';
echo $render_page($template_placeholder);