<?php
namespace Tables;

class ShiftsDays extends Table {

    const TABLE_NAME = 'shifts_days';

    static function init(\PDO $connection): bool {
        $sql =
            'CREATE TABLE IF NOT EXISTS `' . self::TABLE_NAME . '` (
            `id_shift_day` :primary_key,
            `place` varchar(16) NOT NULL,
            `time_from` datetime NOT NULL,
            `time_to` datetime NOT NULL,
            `type` tinyint(1) DEFAULT 1,
            `extra_shift` tinyint(1) DEFAULT 0)';

        return parent::create_table($connection, $sql);
    }

    static function select_all(\PDO $connection, int $days_max, array $types): array {

        $stmt = $connection->query(
            'SELECT id_shift_day, type, place, time_from, time_to, extra_shift
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
            'INSERT INTO ' . self::TABLE_NAME . ' (type, place, time_from, time_to, extra_shift)
		    VALUES (:type, :place, :date_from, :date_to, :extra_shift)'
        );

        $smtp->execute(
            array(
                ':type' => $shift_day->get_type(),
                ':place' => $shift_day->get_place(),
                ':date_from' => $shift_day->get_datetime_from()->format('Y-m-d H:i:s'),
                ':date_to' => $shift_day->get_datetime_to()->format('Y-m-d H:i:s'),
                ':extra_shift' => ($shift_day->is_extra_shift()) ? 1 : 0
            )
        );
        return (int)$connection->lastInsertId();
    }
}