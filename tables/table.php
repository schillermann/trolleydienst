<?php
namespace Tables;

class Table {
    const PRIMARY_KEY_SQLITE = 'INTEGER PRIMARY KEY AUTOINCREMENT';
    const PRIMARY_KEY_MYSQL = 'int(11) unsigned NOT NULL AUTO_INCREMENT';

    static function create_table(\PDO $connection, string $sql): bool {

        if($connection->getAttribute(\PDO::ATTR_DRIVER_NAME) == 'sqlite')
            $primary_key = self::PRIMARY_KEY_SQLITE;
        else
            $primary_key = self::PRIMARY_KEY_MYSQL;

        $sql_with_primary_key = str_replace(':primary_key', $primary_key, $sql);

        $count_changes = $connection->exec($sql_with_primary_key);

        return ($count_changes === false)? false : true;
    }
}