<?php
require 'config.php';
try {
    return new \PDO(
        'mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME,
        DATABASE_USER,
        DATABASE_PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
} catch (PDOException $exception) {
    exit('Database connection failed: ' . $exception->getMessage());
}
