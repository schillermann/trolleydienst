<?php
namespace Tables;

class Infos {

    const TABLE_NAME = 'infos';

    static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_info` INTEGER PRIMARY KEY AUTOINCREMENT,
            `label` TEXT NOT NULL,
            `type` INTEGER NOT NULL,
            `file_name` TEXT NOT NULL,
            `file_hash` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection): array {
        $stmt = $connection->query(
            'SELECT id_info, label, type, file_name, file_hash
            FROM ' . self::TABLE_NAME . '
            ORDER BY type'
        );

        $result = $stmt->fetchAll();
        return ($result === false)? array() : $result;
    }

    static function select(\PDO $connection, int $id_info): array {
        $stmt = $connection->prepare(
            'SELECT id_info, label, file_name, file_hash, type
            FROM ' . self::TABLE_NAME . '
            WHERE id_info = :id_info'
        );

        $stmt->execute(
            array(':id_info' => $id_info)
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function insert(\PDO $connection, string $label, int $type, string $file_name, string $file_hash): bool {
        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (label, type, file_name, file_hash)
            VALUES (:label, :type, :file_name, :file_hash)'
        );

        $stmt->execute(
            array(
                ':label' => $label,
                ':type' => $type,
                ':file_name' => $file_name,
                ':file_hash' => $file_hash
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function delete(\PDO $connection, int $id_info): bool {
        $stmt = $connection->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' WHERE id_info = :id_info'
        );

        return $stmt->execute(
            array(':id_info' => $id_info)
        );
    }

    static function update(\PDO $connection, int $id_info, string $label, int $type): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET label = :label, type = :type
            WHERE id_info = :id_info'
        );

        return $stmt->execute(
            array(
                ':file_label' => $label,
                ':file_type' => $type,
                ':id_file' => $id_info
            )
        );
    }
}