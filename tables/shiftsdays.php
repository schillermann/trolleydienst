<?php
namespace Tables;

class ShiftsDays {

    const TABLE_NAME = 'shifts_days';

    static function create_table(\PDO $connection): bool {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_shift_day` INTEGER PRIMARY KEY AUTOINCREMENT,
            `id_shift_type` INTEGER NOT NULL,
            `place` TEXT NOT NULL,
            `time_from` TEXT NOT NULL,
            `number` INTEGER DEFAULT 1,
            `hours_per_shift` INTEGER DEFAULT 1,
            `color_hex` TEXT DEFAULT "#d5c8e4")';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_place(\PDO $connection, int $id_shift_day): string {
        $stmt = $connection->prepare(
            'SELECT place
            FROM ' . self::TABLE_NAME . '
            WHERE id_shift_day = :id_shift_day'
        );

        $stmt->execute(array(':id_shift_day' => $id_shift_day));

        $result = $stmt->fetchColumn();
        return ($result)? $result : '';
    }

    static function select_all(\PDO $connection, int $id_shift_type): array {

        $stmt = $connection->prepare(
            'SELECT id_shift_day, place, time_from, number, hours_per_shift, color_hex
            FROM ' . self::TABLE_NAME . '
            WHERE time_to >= datetime("now")
            AND id_shift_type = :id_shift_type
            ORDER BY time_from ASC'
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
            (id_shift_type, place, time_from, number, hours_per_shift, color_hex)
		    VALUES (:id_shift_type, :place, :date_from, :number, :hours_per_shift, :color_hex)'
        );

        $stmt->execute(
            array(
                ':id_shift_type' => $shift_day->get_id_shift_type(),
                ':place' => $shift_day->get_place(),
                ':date_from' => $shift_day->get_datetime_from()->format('Y-m-d H:i:s'),
                ':number' => $shift_day->get_number(),
                ':hours_per_shift' => $shift_day->get_hours_per_shift(),
                ':color_hex' => $shift_day->get_color_hex()
            )
        );
        return (int)$connection->lastInsertId();
    }

    static function update(\PDO $connection, int $id_shift_day, string $place): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET place = :place
            WHERE id_shift_day = :id_shift_day'
        );

        return $stmt->execute(
            array(
                ':place' => $place,
                ':id_shift_day' => $id_shift_day
            )
        );
    }
}