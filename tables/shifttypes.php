<?php
namespace Tables;

class ShiftTypes {
    const TABLE_NAME = 'shift_types';

    static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE ' . self::TABLE_NAME . ' (
            id_shift_type INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            user_per_shift_max INTEGER DEFAULT 2,
            info TEXT
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select(\PDO $connection, int $id_shift_type): array {
        $stmt = $connection->prepare(
            'SELECT name, user_per_shift_max
          FROM ' . self::TABLE_NAME . '
          WHERE id_shift_type = ' . $id_shift_type
        );

        $stmt->execute();

        $result = $stmt->fetch();
        return ($result)? $result : array();
    }

    static function select_first_id_shift_type(\PDO $connection) {
        $stmt = $connection->prepare(
            'SELECT id_shift_type
          FROM ' . self::TABLE_NAME . ' LIMIT 1'
        );

        $stmt->execute();

        $result = $stmt->fetchColumn();
        return ($result)? $result : 0;
    }

    static function select_user_per_shift_max(\PDO $connection, int $id_shift_type): int {
        $stmt = $connection->prepare(
            'SELECT user_per_shift_max
          FROM ' . self::TABLE_NAME . '
          WHERE id_shift_type = :id_shift_type'
        );

        $stmt->execute(
            array(':id_shift_type' => $id_shift_type)
        );

        $result = $stmt->fetchColumn();
        return ($result)? (int)$result : 2;
    }

    static function select_all(\PDO $connection): array {
        $stmt = $connection->prepare(
            'SELECT id_shift_type, name, user_per_shift_max FROM ' . self::TABLE_NAME
        );

        $stmt->execute();

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }

    static function insert(\PDO $connection, string $name, int $user_per_shift_max = 2): bool {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (name, user_per_shift_max, info) VALUES (:name, :user_per_shift_max, :info)'
        );

        $stmt->execute(
            array(
                ':name' => $name,
                ':user_per_shift_max' => $user_per_shift_max
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function update(\PDO $connection, int $id_shift_type, string $name, int $user_per_shift_max): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET name = :name, user_per_shift_max = :user_per_shift_max
            WHERE id_shift_type = :id_shift_type'
        );

        $stmt->execute(
            array(
                ':name' => $name,
                ':user_per_shift_max' => $user_per_shift_max,
                ':id_shift_type' => $id_shift_type
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function delete(\PDO $connection, int $id_shift_type): bool {
        $stmt = $connection->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' WHERE id_shift_type = :id_shift_type'
        );

        return $stmt->execute(
            array(':id_shift_type' => $id_shift_type)
        );
    }
}