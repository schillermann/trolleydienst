<?php
namespace Tables;

class Shifts {
    static function update(\PDO $connection, \Models\Shift $shift): bool {
        $stmt = $connection->prepare(
            'UPDATE schichten
            SET von = :shift_from, bis = :shift_to
            WHERE terminnr = :id_shift_day
            AND Schichtnr = :id_shift'
        );

        $stmt->execute(
            array(
                ':id_shift_day' => $shift->get_id_shift_day(),
                ':shift_from' => $shift->get_time_from()->format('Y-m-d H:i:s'),
                ':shift_to' => $shift->get_time_to()->format('Y-m-d H:i:s'),
                ':id_shift' => $shift->get_id_shift()
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function insert(\PDO $connection, \Models\Shift $shift): bool {
        $stmt = $connection->prepare(
            'INSERT INTO schichten
            (terminnr, status, von, bis, Schichtnr, status_1, status_2, status_3)
            VALUES (:id_shift_day, 0 , :shift_from, :shift_to, :id_shift, 0, 0, 0)'
        );

        $stmt->execute(
            array(
                ':id_shift_day' => $shift->get_id_shift_day(),
                ':shift_from' => $shift->get_time_from()->format('Y-m-d H:i:s'),
                ':shift_to' => $shift->get_time_to()->format('Y-m-d H:i:s'),
                ':id_shift' => $shift->get_id_shift()
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function select_all(\PDO $connection, int $id_shift_day): array {
        $stmt = $connection->prepare(
            'SELECT sch.terminnr AS id_shift_day, sch.Schichtnr AS id_shift, sch.von AS time_from, sch.bis AS time_to
        FROM schichten sch
        WHERE sch.terminnr = :id_shift_day
        ORDER BY sch.Schichtnr'
        );

        $stmt->execute(
            array(':id_shift_day' => $id_shift_day)
        );

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }
}