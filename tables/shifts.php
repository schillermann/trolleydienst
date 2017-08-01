<?php
namespace Tables;

class Shifts {

    const TABLE_NAME = 'shifts';

    static function create_table(\PDO $connection): bool {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_shift` INTEGER PRIMARY KEY AUTOINCREMENT,
            `id_shift_type` INTEGER NOT NULL,
            `place` TEXT NOT NULL,
            `datetime_from` TEXT NOT NULL,
            `number` INTEGER DEFAULT 1,
            `minutes_per_shift` INTEGER DEFAULT 60,
            `color_hex` TEXT DEFAULT "#d5c8e4")';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_place(\PDO $connection, int $id_shift): string {
        $stmt = $connection->prepare(
            'SELECT place
            FROM ' . self::TABLE_NAME . '
            WHERE id_shift = :id_shift'
        );

        $stmt->execute(array(':id_shift' => $id_shift));

        $result = $stmt->fetchColumn();
        return ($result)? $result : '';
    }

    static function select_all(\PDO $connection, int $id_shift_type): array {

        $stmt = $connection->prepare(
            'SELECT id_shift, place, datetime_from, number, minutes_per_shift, color_hex
            FROM ' . self::TABLE_NAME . '
            WHERE DATE(datetime_from) >= DATE("now")
            AND id_shift_type = :id_shift_type
            ORDER BY datetime_from ASC'
        );

        $stmt->execute(array(':id_shift_type' => $id_shift_type));

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }

    /**
     * @param \PDO $connection
     * @param \Models\ShiftDay $shift_day
     * @return int Shiftday ID
     */
    static function insert(\PDO $connection, \Models\ShiftDay $shift_day): int {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (id_shift_type, place, datetime_from, number, minutes_per_shift, color_hex)
		    VALUES (:id_shift_type, :place, :date_from, :number, :minutes_per_shift, :color_hex)'
        );

        $stmt->execute(
            array(
                ':id_shift_type' => $shift_day->get_id_shift_type(),
                ':place' => $shift_day->get_place(),
                ':date_from' => $shift_day->get_datetime_from()->format('Y-m-d H:i:s'),
                ':number' => $shift_day->get_number(),
                ':minutes_per_shift' => $shift_day->get_minutes_per_shift(),
                ':color_hex' => $shift_day->get_color_hex()
            )
        );
        return (int)$connection->lastInsertId();
    }

    static function update(\PDO $connection, int $id_shift, string $place): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET place = :place
            WHERE id_shift = :id_shift'
        );

        return $stmt->execute(
            array(
                ':place' => $place,
                ':id_shift' => $id_shift
            )
        );
    }
}