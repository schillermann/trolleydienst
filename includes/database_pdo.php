<?php
require 'config.php';
try {
    return new \PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
} catch (PDOException $exception) {
    exit('Es konnte keine Verbindung zur Datenbank hergestellt werden. Bitte prüfe in der Datei config.php ob die richtigen Verbindungsdaten zur Datenbank hinterlegt sind.');
}
