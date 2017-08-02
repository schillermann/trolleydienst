<?php
namespace Tables;

class Shifts {

    const TABLE_NAME = 'shifts';

    static function create_table(\PDO $connection): bool {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_shift` INTEGER PRIMARY KEY AUTOINCREMENT,
            `id_shift_type` INTEGER NOT NULL,
            `route` TEXT NOT NULL,
            `datetime_from` TEXT NOT NULL,
            `number` INTEGER DEFAULT 1,
            `minutes_per_shift` INTEGER DEFAULT 60,
            `color_hex` TEXT DEFAULT "#d5c8e4")';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select(\PDO $connection, int $id_shift): array {
        $stmt = $connection->prepare(
            'SELECT route, datetime_from, number, minutes_per_shift, color_hex
            FROM ' . self::TABLE_NAME . '
            WHERE id_shift = :id_shift'
        );

        $stmt->execute(array(':id_shift' => $id_shift));

        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function select_all(\PDO $connection, int $id_shift_type): array {

        $stmt = $connection->prepare(
            'SELECT id_shift, route, datetime_from, number, minutes_per_shift, color_hex
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
     * @param \Models\Shift $shift
     * @return int Shiftday ID
     */
    static function insert(\PDO $connection, \Models\Shift $shift): int {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex)
		    VALUES (:id_shift_type, :route, :date_from, :number, :minutes_per_shift, :color_hex)'
        );

        $stmt->execute(
            array(
                ':id_shift_type' => $shift->get_id_shift_type(),
                ':route' => $shift->get_route(),
                ':date_from' => $shift->get_datetime_from()->format('Y-m-d H:i:s'),
                ':number' => $shift->get_number(),
                ':minutes_per_shift' => $shift->get_minutes_per_shift(),
                ':color_hex' => $shift->get_color_hex()
            )
        );
        return (int)$connection->lastInsertId();
    }

    static function update(\PDO $connection, \Models\Shift $shift): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET route = :route, datetime_from = :datetime_from, minutes_per_shift = :minutes_per_shift, color_hex = :color_hex
            WHERE id_shift = :id_shift'
        );

        return $stmt->execute(
            array(
                ':route' => $shift->get_route(),
                ':datetime_from' => $shift->get_datetime_from()->format('Y-m-d H:i:s'),
                ':minutes_per_shift' => $shift->get_minutes_per_shift(),
                ':color_hex' => $shift->get_color_hex(),
                ':id_shift' => $shift->get_id_shift()
            )
        );
    }
}