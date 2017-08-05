<?php
namespace Tables;

class History {
    const TABLE_NAME = 'history';
    const SHIFT_WITHDRAWN_SUCCESS = 'shift withdrawn success';
    const SHIFT_WITHDRAWN_ERROR = 'shift withdrawn error';

    const SHIFT_PROMOTE_SUCCESS = 'shift promote success';
    const SHIFT_PROMOTE_ERROR = 'shift promote error';

    const LOGIN_ERROR = 'login error';

    static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_history` INTEGER PRIMARY KEY AUTOINCREMENT,
            `user` TEXT NOT NULL,
            `type` TEXT NOT NULL,
            `message` TEXT NOT NULL,
            `datetime` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection, array $type): array {
        $stmt = $connection->prepare(
            'SELECT user, type, message, datetime
            FROM ' . self::TABLE_NAME . '
            WHERE type = "' . join('" OR type = "', $type) . '"
            ORder BY datetime DESC'
        );

        $stmt->execute();

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }

    static function insert(\PDO $connection, string $user, string $type, string $message): bool {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (user, type, message, datetime)
		    VALUES (:user, :type, :message, datetime("now", "localtime"))'
        );

        $stmt->execute(
            array(
                ':user' => $user,
                ':type' => $type,
                ':message' => $message
            )
        );
        return $stmt->rowCount() == 1;
    }
}