<?php
return function (\PDO $database, int $id_appointment): array {

    $stmt_shift_list = $database->prepare(
        'SELECT sch.terminnr AS id_appointment, sch.Schichtnr AS id_shift, sch.von AS time_from, sch.bis AS time_to
        FROM schichten sch
        WHERE sch.terminnr = :id_appointment
        ORDER BY sch.Schichtnr'
    );

    $stmt_shift_list->execute(
        array(':id_appointment' => $id_appointment)
    );

    return $stmt_shift_list->fetchAll(PDO::FETCH_CLASS, 'Models\Shift');
};