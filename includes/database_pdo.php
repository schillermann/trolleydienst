<?php
require 'config.php';
$pdo_driver_list = PDO::getAvailableDrivers();

if(DATABASE_SQLITE && !in_array('sqlite', $pdo_driver_list))
    exit('Sqlite driver is not installed!');
elseif(!in_array('mysql', $pdo_driver_list))
    exit('MySQL driver is not installed!');

try {

    if(DATABASE_SQLITE) {
        $database_file = DATABASE_NAME . '.sqlite';
        $create_tables = !file_exists($database_file);
        $pdo = new \PDO('sqlite:' . $database_file);

        if($create_tables) {
            Tables\Users::int($pdo);
            Tables\ShiftsDays::int($pdo);
            Tables\Shifts::int($pdo);
            Tables\ShiftUserMaps::int($pdo);
            Tables\Infos::int($pdo);
        }
    }
    else
        $pdo = new \PDO(
            'mysql:host=' . DATABASE_MYSQL_HOST . ';dbname=' . DATABASE_NAME,
            DATABASE_MYSQL_USER,
            DATABASE_MYSQL_PASSWORD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
} catch (PDOException $exception) {
    exit('Database connection failed: ' . $exception->getMessage());
}

$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
return $pdo;