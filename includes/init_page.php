<?php
session_start();
if(empty($_SESSION)) {
    header('location: /');
    return;
}

include 'config.php';
spl_autoload_register();