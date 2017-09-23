<?php
namespace Tables;

class Templates
{
    const TABLE_NAME = 'templates';
    const EMAIL_SIGNATURE = 'email signature';
    const EMAIL_INFO = 'email info';
    const EMAIL_PASSWORD_FORGOT = 'email password forgot';

    static function create_table(\PDO $connection): bool {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
                `name` TEXT NOT NULL PRIMARY KEY,
                `subject` TEXT,
                `message` TEXT NOT NULL,
                `updated` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false) ? false : true;
    }

    static function select(\PDO $connection, string $name): array {
        $stmt = $connection->prepare(
            'SELECT subject, message, updated
            FROM ' . self::TABLE_NAME . '
            WHERE name = :name'
        );

        if(!$stmt->execute(
            array(':name' => $name)
        ))
        	return array();

        $result = $stmt->fetch();
        return ($result)? $result : array();
    }

    static function update(\PDO $connection, string $name, string $message, string $subject = null): bool {

        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET subject = :subject, message = :message, updated = datetime("now", "localtime")
            WHERE name = :name'
        );

        return $stmt->execute(
            array(
                ':subject' => $subject,
                ':message' => $message,
                ':name' => $name
            )
        ) && $stmt->rowCount() == 1;
    }
}