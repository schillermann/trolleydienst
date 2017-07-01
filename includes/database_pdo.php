<?php
require 'config.php';
$pdo_driver_list = PDO::getAvailableDrivers();

if(DATABASE_SQLITE && !in_array('sqlite', $pdo_driver_list))
    exit('Sqlite driver is not installed!');

$create_tables = !file_exists($database_file);

try {
    $pdo = new \PDO('sqlite:' . DATABASE_NAME);
} catch (PDOException $exception) {
    exit('Database connection failed: ' . $exception->getMessage());
}

if($create_tables) {
    Tables\Users::create_table($pdo);
    Tables\ShiftsDays::create_table($pdo);
    Tables\Shifts::create_table($pdo);
    Tables\ShiftUserMaps::create_table($pdo);
    Tables\Infos::create_table($pdo);
}

$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
return $pdo;