<?php
session_start();

if(empty($_SESSION))
    header('location: /');
include 'settings.php';

spl_autoload_register();