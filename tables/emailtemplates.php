<?php
namespace Tables;

class EmailTemplates
{
    const TABLE_NAME = 'email_templates';

    const SIGNATURE = 1;
    const INFO = 2;
    const PASSWORD_FORGOT = 3;
    const USER_PROMOTE = 4;

    static function create_table(\PDO $connection): bool {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
                `id_email_template` INTEGER PRIMARY KEY AUTOINCREMENT,
				`subject` TEXT,
				`message` TEXT NOT NULL,
				`updated` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false) ? false : true;
    }

    static function select(\PDO $connection, int $id_email_template): array {
        $stmt = $connection->prepare(
            'SELECT subject, message, updated
            FROM ' . self::TABLE_NAME . '
            WHERE id_email_template = :id_email_template'
        );

        if(!$stmt->execute(
            array(':id_email_template' => $id_email_template)
        ))
        	return array();

        $result = $stmt->fetch();
        return ($result)? $result : array();
    }

    static function update(\PDO $connection, int $id_email_template, string $message, string $subject = null): bool {

        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET subject = :subject, message = :message, updated = datetime("now", "localtime")
            WHERE id_email_template = :id_email_template'
        );

        return $stmt->execute(
            array(
                ':subject' => $subject,
                ':message' => $message,
                ':id_email_template' => $id_email_template
            )
        ) && $stmt->rowCount() == 1;
    }
}