<?php
session_start();

if(empty($_SESSION))
    header('location: /');

spl_autoload_register();

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
    'SELECT terminnr AS id_schedule, art AS type, ort AS place,
    termin_von AS datetime_from,
    termin_bis AS datetime_to,
    DATEDIFF(termin_von,curdate()) AS datetime_diff,
    coalesce(sonderschicht,0) as shift_extra
    FROM termine
    WHERE art IN(' . implode(',', $AllowSchichtArt) . ')
    AND (datediff(curdate(),termin_von) <= :schedule_max_days )
    ORDER BY termin_von ASC'
);

$stmt_schedule->execute(
    array(':schedule_max_days' => (int)$mTageFilter)
);

$template_placeholder = array();
$template_placeholder['schedule_list'] = array();

while ($next_schedule = $stmt_schedule->fetchObject('Models\Schedule')) {

    $stmt_shifts = $database_pdo->prepare(
        'SELECT sch.terminnr AS id_schedule, sch.Schichtnr AS id_shift, sch.von AS datetime_from, sch.bis AS datetime_to
        FROM schichten sch
        WHERE sch.terminnr = :id_schedule
        ORDER BY sch.Schichtnr'
    );

    $stmt_shifts->execute(
        array(':id_schedule' => $next_schedule->get_schedule_id())
    );

    while ($shift = $stmt_shifts->fetchObject('Models\Shift')) {

        $stmt_users_from_shift = $database_pdo->prepare(
            'SELECT SchTeil.teilnehmernr AS id_user, SchTeil.status AS status,
            SchTeil.isschichtleiter AS shift_supervisor, muser.vorname AS firstname,
            muser.nachname AS surname, muser.Handy AS mobile
            FROM schichten_teilnehmer SchTeil
            LEFT OUTER JOIN teilnehmer muser
            ON SchTeil.teilnehmernr = muser.teilnehmernr
            WHERE SchTeil.terminnr = :id_schedule
            AND SchTeil.schichtnr = :id_shift
            ORDER BY SchTeil.isschichtleiter DESC'
        );

        $stmt_users_from_shift->execute(
            array(
                ':id_schedule' => $shift->get_id_schedule(),
                ':id_shift' => $shift->get_id_shift()
            )
        );

        while($user_from_shift = $stmt_users_from_shift->fetchObject('Models\ShiftUser'))
            $shift->add_shift_user($user_from_shift);

        $next_schedule->add_shift($shift);
    }

    $template_placeholder['schedule_list'][] = $next_schedule;
}

$render_page = include 'includes/page_render.php';
echo $render_page($template_placeholder);