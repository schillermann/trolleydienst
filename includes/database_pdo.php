<?php
require 'config.php';

if(!file_exists(DATABASE_SQLITE))
    header('location: install.php');

try {
    $pdo = new \PDO('sqlite:' . DATABASE_SQLITE);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    return $pdo;
} catch (PDOException $exception) {
    exit('Database connection failed: ' . $exception->getMessage());
}

/*
if($create_tables) {
    Tables\Users::create_table($pdo);
    Tables\ShiftsDays::create_table($pdo);
    Tables\Shifts::create_table($pdo);
    Tables\ShiftUserMaps::create_table($pdo);
    Tables\Infos::create_table($pdo);

    $render_page = include 'includes/render_page.php';
    echo $render_page($placeholder);

    //Tables\Users::insert($pdo, $user);
}*/