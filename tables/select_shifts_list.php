<?php
return function (\PDO $database, int $id_shift_day): array {

    $stmt_shift_list = $database->prepare(
        'SELECT sch.terminnr AS id_shift_day, sch.Schichtnr AS id_shift, sch.von AS time_from, sch.bis AS time_to
        FROM schichten sch
        WHERE sch.terminnr = :id_shift_day
        ORDER BY sch.Schichtnr'
    );

    $stmt_shift_list->execute(
        array(':id_shift_day' => $id_shift_day)
    );

    return $stmt_shift_list->fetchAll(PDO::FETCH_CLASS, 'Models\Shift');
};