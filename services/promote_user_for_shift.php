<?php
return function (\PDO $database, int $id_user, int $id_shift_day, int $id_shift): bool {

    $stmt_add_user_to_shift = $database->prepare(
        'INSERT INTO schichten_teilnehmer
        (terminnr, schichtnr, teilnehmernr, status, isschichtleiter)
        VALUES (:id_appointment, :id_shift, :id_user, 0, 0)'
    );

    $stmt_add_user_to_shift->execute(
        array(
            ':id_appointment' => $id_shift_day,
            ':id_shift' => $id_shift,
            ':id_user' => $id_user
        )
    );

    return $stmt_add_user_to_shift->rowCount() == 1;
};