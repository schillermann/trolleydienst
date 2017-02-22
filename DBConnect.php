<?php
$verbindung = mysql_connect('localhsot', 'database_user', 'database_password')
or die ("keine Verbindung möglich. Benutzername oder Passwort sind falsch");

mysql_select_db('database_name')
or die ("Die Datenbank existiert nicht.");
?>
