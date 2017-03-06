<?php
session_start();

if(empty($_SESSION))
    header('location: /');

spl_autoload_register();