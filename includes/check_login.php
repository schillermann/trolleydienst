<?php
return function (\PDO $database_pdo, string $username, string $password): bool {

    $user = Tables\Users::select_logindata($database_pdo, $username, $password);

    if(empty($user))
        return false;

    $_SESSION['id_user'] = (int)$user['id_user'];
    $_SESSION['name'] = $user['firstname'] . ' ' . $user['lastname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['is_literature_table'] = (bool)$user['is_literature_table'];
    $_SESSION['is_literature_cart'] = (bool)$user['is_literature_cart'];
    $_SESSION['role'] = ($user['is_admin']) ? 'admin' : 'user';

    Tables\Users::update_login_time($database_pdo, $_SESSION['id_user']);

    return true;
};