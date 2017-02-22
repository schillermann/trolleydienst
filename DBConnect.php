<?php
function connect_to_database(string $host, string $name, string $user, string $password) : \PDO {

    try {
        return new \PDO('mysql:host=' . $host . ';dbname=' . $name, $user, $password);
    } catch (PDOException $exception) {
        exit('Es konnte keine Verbindung zur Datenbank hergestellt werden. Bitte prüfe in der Datei config.php ob die richtigen Verbindungsdaten zur Datenbank hinterlegt sind.');
    }
}