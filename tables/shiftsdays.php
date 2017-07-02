<?php
namespace Tables;

class ShiftsDays {

    const TABLE_NAME = 'shifts_days';

    static function create_table(\PDO $connection): bool {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_shift_day` INTEGER PRIMARY KEY AUTOINCREMENT,
            `place` TEXT NOT NULL,
            `time_from` TEXT NOT NULL,
            `time_to` TEXT NOT NULL,
            `type` INTEGER DEFAULT 1)';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection, int $days_max, array $types): array {

        $stmt = $connection->query(
            'SELECT id_shift_day, type, place, time_from, time_to
            FROM ' . self::TABLE_NAME . '
            WHERE type IN(' . implode(',', $types) . ')
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
            'INSERT INTO ' . self::TABLE_NAME . ' (type, place, time_from, time_to)
		    VALUES (:type, :place, :date_from, :date_to)'
        );

        $smtp->execute(
            array(
                ':type' => $shift_day->get_type(),
                ':place' => $shift_day->get_place(),
                ':date_from' => $shift_day->get_datetime_from()->format('Y-m-d H:i:s'),
                ':date_to' => $shift_day->get_datetime_to()->format('Y-m-d H:i:s')
            )
        );
        return (int)$connection->lastInsertId();
    }
}