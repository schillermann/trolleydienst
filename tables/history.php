<?php
namespace Tables;

class History {
    const TABLE_NAME = 'history';
    const SHIFT_WITHDRAWN_SUCCESS = 'shift withdrawn success';
    const SHIFT_WITHDRAWN_ERROR = 'shift withdrawn error';

    const SHIFT_PROMOTE_SUCCESS = 'shift promote success';
    const SHIFT_PROMOTE_ERROR = 'shift promote error';

    static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_history` INTEGER PRIMARY KEY AUTOINCREMENT,
            `id_user` INTEGER NOT NULL,
            `type` TEXT NOT NULL,
            `description` TEXT NOT NULL,
            `datetime` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection, array $type): array {
        $stmt = $connection->prepare(
            'SELECT firstname || " " || lastname AS name, type, description, datetime
            FROM ' . self::TABLE_NAME . '
            LEFT JOIN users
            ON ' . self::TABLE_NAME . '.id_user = users.id_user
            WHERE type = "' . join('" OR type = "', $type) . '"'
        );

        $stmt->execute();

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }

    static function insert(\PDO $connection, int $id_user, string $type, string $description): bool {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (id_user, type, description, datetime)
		    VALUES (:id_user, :type, :description, datetime("NOW"))'
        );

        $stmt->execute(
            array(
                ':id_user' => $id_user,
                ':type' => $type,
                ':description' => $description
            )
        );
        return $stmt->rowCount() == 1;
    }
}