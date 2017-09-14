<?php
namespace Tables;

class Infos {

    const TABLE_NAME = 'infos';

    static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_info` INTEGER PRIMARY KEY AUTOINCREMENT,
            `file_label` TEXT NOT NULL,
            `file_name_hash` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection): array {
        $stmt = $connection->query(
            'SELECT id_info, file_label, file_name_hash
            FROM ' . self::TABLE_NAME . '
            ORDER BY file_label'
        );

        $result = $stmt->fetchAll();
        return ($result === false)? array() : $result;
    }

    static function select(\PDO $connection, int $id_info): array {
        $stmt = $connection->prepare(
            'SELECT id_info, file_label, file_name_hash
            FROM ' . self::TABLE_NAME . '
            WHERE id_info = :id_info'
        );

        $stmt->execute(
            array(':id_info' => $id_info)
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function insert(\PDO $connection, string $file_label, string $file_name_hash): bool {
        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (file_label, file_name_hash)
            VALUES (:file_label, :file_name_hash)'
        );

        $stmt->execute(
            array(
                ':file_label' => $file_label,
                ':file_name_hash' => $file_name_hash
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

    static function update(\PDO $connection, int $id_info, string $file_label): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . ' SET file_label = :file_label WHERE id_info = :id_info'
        );

        return $stmt->execute(
            array(
                ':file_label' => $file_label,
                ':id_info' => $id_info
            )
        );
    }
}