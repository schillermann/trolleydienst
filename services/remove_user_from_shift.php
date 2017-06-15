<?php
return function (\PDO $database, int $id_user, int $id_shift_day, int $id_shift): bool {

    $stmt_delete_user_from_shift = $database->prepare(
        'DELETE FROM schichten_teilnehmer 
    WHERE terminnr = :id_shift_day
    AND Schichtnr = :id_shift
    AND teilnehmernr = :id_user'
    );

    $stmt_delete_user_from_shift->execute(
        array(
            ':id_shift_day' => $id_shift_day,
            ':id_shift' => $id_shift,
            ':id_user' => $id_user
        )
    );

    return $stmt_delete_user_from_shift->rowCount() == 1;
};