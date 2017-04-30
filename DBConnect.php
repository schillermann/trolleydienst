<?php
/**
 * @param string $host
 * @param string $name
 * @param string $user
 * @param string $password
 * @return PDO
 */
function connect_to_database($host, $name, $user, $password) {

    try {
        return new PDO('mysql:host=' . $host . ';dbname=' . $name, $user, $password);
    } catch (PDOException $exception) {
        exit('Verbindung fehlgeschlagen: ' . $exception->getMessage());
    }
}