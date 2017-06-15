<?php
return function (\PDO $database, Models\Shift $shift) {
    $stmt_insert_shift = $database->prepare(
        'INSERT INTO schichten
            (terminnr, status, von, bis, Schichtnr, status_1, status_2, status_3)
            VALUES (:id_shift_day, 0 , :shift_from, :shift_to, :id_shift, 0, 0, 0)'
    );

    $stmt_insert_shift->execute(
        array(
            ':id_shift_day' => $shift->get_id_shift_day(),
            ':shift_from' => $shift->get_time_from()->format('Y-m-d H:i:s'),
            ':shift_to' => $shift->get_time_to()->format('Y-m-d H:i:s'),
            ':id_shift' => $shift->get_id_shift()
        )
    );

    return $stmt_insert_shift->rowCount() == 1;
};