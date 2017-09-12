<?php
session_start();

if(isset($_GET['logout'])) {
    $_SESSION = array();
    header('location: /');
    return;
}

if(isset($_SESSION) && !empty($_SESSION)) {
    header('location: shift.php');
    return;
}

spl_autoload_register();

if(!Tables\Database::exists_database()) {
    header('location: install.php');
    return;
}

include 'config.php';
$placeholder = array();

if(isset($_POST['name']) && isset($_POST['password'])) {

    $check_login = include 'includes/check_login.php';
    $name = include 'filters/post_name.php';
    $database_pdo = Tables\Database::get_connection();

    if($check_login($database_pdo, $name, $_POST['password'])) {
        header('location: shift.php');
        return;
    }
    else {
        $placeholder['message']['error'] = 'Anmeldung ist fehlgeschlagen!';

        Tables\History::insert(
            $database_pdo,
			$name,
            Tables\History::LOGIN_ERROR,
            $placeholder['message']['error']
        );
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);
?>