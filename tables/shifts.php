<?php
namespace Tables;

class Shifts {

    const TABLE_NAME = 'shifts';

    static function create_table(\PDO $connection): bool {

        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_shift` INTEGER PRIMARY KEY AUTOINCREMENT,
            `id_shift_day` INTEGER NOT NULL,
            `time_from` TEXT NOT NULL,
            `time_to` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function update(\PDO $connection, \Models\Shift $shift): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET time_from = :time_from, time_to = :time_to
            WHERE id_shift_day = :id_shift_day
            AND id_shift = :id_shift'
        );

        $stmt->execute(
            array(
                ':id_shift_day' => $shift->get_id_shift_day(),
                ':time_from' => $shift->get_time_from()->format('Y-m-d H:i:s'),
                ':time_to' => $shift->get_time_to()->format('Y-m-d H:i:s'),
                ':id_shift' => $shift->get_id_shift()
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function insert(\PDO $connection, \Models\Shift $shift): bool {
        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (id_shift_day, time_from, time_to)
            VALUES (:id_shift_day, :time_from, :time_to)'
        );

        $stmt->execute(
            array(
                ':id_shift_day' => $shift->get_id_shift_day(),
                ':time_from' => $shift->get_time_from()->format('Y-m-d H:i:s'),
                ':time_to' => $shift->get_time_to()->format('Y-m-d H:i:s')
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function select_all(\PDO $connection, int $id_shift_day): array {
        $stmt = $connection->prepare(
            'SELECT id_shift_day, id_shift, time_from, time_to
            FROM ' . self::TABLE_NAME . '
            WHERE id_shift_day = :id_shift_day'
        );

        $stmt->execute(
            array(':id_shift_day' => $id_shift_day)
        );

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }
}