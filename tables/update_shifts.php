<?php
return function (\PDO $database, Models\Shift $shift): bool {
    $stmt_update_shift = $database->prepare(
'UPDATE schichten
        SET von = :shift_from, bis = :shift_to
        WHERE terminnr = :id_shift_day
        AND Schichtnr = :id_shift'
    );

    $stmt_update_shift->execute(
        array(
            ':id_shift_day' => $shift->get_id_shift_day(),
            ':shift_from' => $shift->get_time_from()->format('Y-m-d H:i:s'),
            ':shift_to' => $shift->get_time_to()->format('Y-m-d H:i:s'),
            ':id_shift' => $shift->get_id_shift()
        )
    );
    return $stmt_update_shift->rowCount() == 1;
};