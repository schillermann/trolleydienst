<?php
namespace Tables;

class ShiftsDays {
    /**
     * @param \PDO $connection
     * @param \Models\ShiftDay $shiftday
     * @return int Id from shifts days
     */
    static function insert(\PDO $connection, \Models\ShiftDay $shiftday): int {
        $stmt_next_id_shift_day = $connection->query(
            'SELECT coalesce(Max(terminnr),0) + 1 FROM termine'
        );

        $id_shift_day = (int)$stmt_next_id_shift_day->fetchColumn();

        $stmt_insert_shifts_days = $connection->prepare(
            'INSERT INTO termine (terminnr, art, ort, termin_von, termin_bis, sonderschicht)
		    VALUES (:id_shift_day, :type, :place, :time_from, :time_to, :extra_shift)'
        );

        $stmt_insert_shifts_days->execute(
            array(
                ':id_shift_day' => $id_shift_day,
                ':type' => $shiftday->get_type(),
                ':place' => $shiftday->get_place(),
                ':time_from' => $shiftday->get_time_from()->format('Y-m-d H:i:s'),
                ':time_to' => $shiftday->get_time_to()->format('Y-m-d H:i:s'),
                ':extra_shift' => $shiftday->is_extra_shift()
            )
        );

        return ($stmt_insert_shifts_days->rowCount() == 1)? $id_shift_day : 0;
    }
}