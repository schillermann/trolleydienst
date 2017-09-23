<?php
namespace Tables;

class ShiftUserMaps {

    const TABLE_NAME = 'shift_user_maps';

    static function create_table(\PDO $connection): bool {

        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_shift` INTEGER NOT NULL,
            `id_user` INTEGER NOT NULL,
            `position` INTEGER DEFAULT 1,
            `created` TEXT NOT NULL,
            PRIMARY KEY (id_shift_day, id_shift, id_user)
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection, int $id_shift): array {
        $stmt = $connection->prepare(
            'SELECT position, users.id_user, name
            FROM ' . self::TABLE_NAME . '
            LEFT JOIN users
            ON ' . self::TABLE_NAME . '.id_user = users.id_user
            WHERE id_shift = :id_shift
            ORDER BY position'
        );

        if(!$stmt->execute(
            array(':id_shift' => $id_shift)
        ))
        	return array();

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }

    static function insert (\PDO $connection, int $id_shift, int $id_user, int $position): bool {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (id_shift, id_user, position, created)
            VALUES (:id_shift, :id_user, :position, datetime("now", "localtime"))'
        );

        return $stmt->execute(
            array(
                ':id_shift' => $id_shift,
                ':id_user' => $id_user,
                ':position' => $position
            )
        ) && $stmt->rowCount() == 1;
    }

    static function delete(\PDO $connection, int $id_shift, int $id_user, int $position): bool {

        $stmt = $connection->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' 
            WHERE id_shift = :id_shift
            AND id_user = :id_user
            AND position = :position'
        );

        return $stmt->execute(
            array(
                ':id_shift' => $id_shift,
                ':id_user' => $id_user,
                ':position' => $position
            )
        ) && $stmt->rowCount() == 1;
    }
}