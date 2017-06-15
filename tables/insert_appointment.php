<?php
/**
 * return int Id date
 */
return function(\PDO $database, Models\Appointment $appointment): int {
    $stmt_next_id_appointment = $database->query(
        'SELECT coalesce(Max(terminnr),0) + 1 FROM termine'
    );

    $next_id_appointment = (int)$stmt_next_id_appointment->fetchColumn();

    $stmt_insert_appointment = $database->prepare(
        'INSERT INTO termine (terminnr, art, ort, termin_von, termin_bis, sonderschicht)
		    VALUES (:id_appointment, :type, :place, :time_from, :time_to, :extra_shift)'
    );

    $id_appointment = ($next_id_appointment > 0) ? $next_id_appointment : 1;

    $stmt_insert_appointment->execute(
        array(
            ':id_appointment' => $id_appointment,
            ':type' => $appointment->get_type(),
            ':place' => $appointment->get_place(),
            ':time_from' => $appointment->get_time_from()->format('Y-m-d H:i:s'),
            ':time_to' => $appointment->get_time_to()->format('Y-m-d H:i:s'),
            ':extra_shift' => $appointment->is_extra_shift()
        )
    );

    return ($stmt_insert_appointment->rowCount() == 1)? $id_appointment : -1;
};