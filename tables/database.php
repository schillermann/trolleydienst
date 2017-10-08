<?php
namespace Tables;

class Database {
    const FILENAME = 'database.sqlite';

    static function get_connection(): \PDO {
        try {
            $pdo = new \PDO('sqlite:' . self::FILENAME);
            $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            return $pdo;
        } catch (PDOException $exception) {
            exit('Database connection failed: ' . $exception->getMessage());
        }
    }

    static function exists_database(): bool {
        return file_exists(self::FILENAME);
    }

    static function create_tables(\PDO $connection): bool {
        return
            Users::create_table($connection) &&
            ShiftsDays::create_table($connection) &&
            Shifts::create_table($connection) &&
            ShiftTypes::create_table($connection) &&
            ShiftUserMaps::create_table($connection) &&
            Infos::create_table($connection) &&
            History::create_table($connection) &&
			Reports::create_table($connection) &&
			AccessFails::create_table($connection);
    }
}