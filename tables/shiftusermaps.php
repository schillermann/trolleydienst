<?php
namespace Tables;

class ShiftUserMaps {

    const TABLE_NAME = 'shift_user_maps';

    static function create_table(\PDO $connection): bool {

        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_shift_day` INTEGER NOT NULL,
            `id_shift` INTEGER NOT NULL,
            `id_user` INTEGER NOT NULL,
            PRIMARY KEY (id_shift_day, id_shift, id_user)
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection, int $id_shift_day, int $id_shift): array {
        $stmt = $connection->prepare(
            'SELECT SchTeil.id_user, muser.firstname,
            muser.lastname, muser.mobile
            FROM ' . self::TABLE_NAME . ' SchTeil
            LEFT OUTER JOIN users muser
            ON SchTeil.id_user = muser.id_user
            WHERE SchTeil.id_shift_day = :id_shift_day
            AND SchTeil.id_shift = :id_shift'
        );

        $stmt->execute(
            array(
                ':id_shift_day' => $id_shift_day,
                ':id_shift' => $id_shift
            )
        );

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }

    static function insert (\PDO $connection, int $id_user, int $id_shift_day, int $id_shift): bool {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (id_shift_day, id_shift, id_user)
            VALUES (:id_shift_day, :id_shift, :id_user)'
        );

        $stmt->execute(
            array(
                ':id_shift_day' => $id_shift_day,
                ':id_shift' => $id_shift,
                ':id_user' => $id_user
            )
        );

        return $stmt->rowCount() == 1;
    }

    static function delete(\PDO $connection, int $id_user, int $id_shift_day, int $id_shift): bool {

        $stmt = $connection->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' 
            WHERE id_shift_day = :id_shift_day
            AND id_shift = :id_shift
            AND id_user = :id_user'
        );

        $stmt->execute(
            array(
                ':id_shift_day' => $id_shift_day,
                ':id_shift' => $id_shift,
                ':id_user' => $id_user
            )
        );

        return $stmt->rowCount() == 1;
    }
}