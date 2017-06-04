<?php
require 'includes/init_page.php';

$database_pdo = include 'includes/database_pdo.php';

if(isset($_POST['save'])) {
    $user = new Models\User();
    $user ->set_firstname($_POST['firstname']);
    $user->set_surname($_POST['surname']);
    //TODO. Hier weiter machen
}

$template_placeholder = array();

$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);