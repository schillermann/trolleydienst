<?php
namespace Tables;

class ShiftsDays {

    const TABLE_NAME = 'shifts_days';

    static function create_table(\PDO $connection): bool {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_shift_day` INTEGER PRIMARY KEY AUTOINCREMENT,
            `id_shift_day_type` INTEGER NOT NULL,
            `place` TEXT NOT NULL,
            `time_from` TEXT NOT NULL,
            `time_to` TEXT NOT NULL,
            `color_hex` TEXT DEFAULT "#d5c8e4")';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection): array {

        $stmt = $connection->query(
            'SELECT id_shift_day, id_shift_day_type, place, time_from, time_to, color_hex
            FROM ' . self::TABLE_NAME . '
            ORDER BY time_from ASC'
        );

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }

    /**
     * @param \PDO $connection
     * @param \Models\ShiftDay $shift_day
     * @return int Shiftday ID
     */
    static function insert(\PDO $connection, \Models\ShiftDay $shift_day): int {

        $smtp = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (id_shift_day_type, place, time_from, time_to, color_hex)
		    VALUES (:id_shift_day_type, :place, :date_from, :date_to, :color_hex)'
        );

        $smtp->execute(
            array(
                ':id_shift_day_type' => $shift_day->get_id_shift_day_type(),
                ':place' => $shift_day->get_place(),
                ':date_from' => $shift_day->get_datetime_from()->format('Y-m-d H:i:s'),
                ':date_to' => $shift_day->get_datetime_to()->format('Y-m-d H:i:s'),
                ':color_hex' => $shift_day->get_color_hex()
            )
        );
        return (int)$connection->lastInsertId();
    }
}