<?php
return function (\PDO $database_pdo, string $username, string $password): bool {

    $select_users_id_user_by_username_and_password = include 'tables/select_users_id_user_by_username_and_password.php';
    $id_user = $select_users_id_user_by_username_and_password($database_pdo, $username, md5($password));

    if($id_user === 0)
        return false;

    $select_users = include 'tables/select_users.php';
    $user = $select_users($database_pdo, $id_user);

    $_SESSION['id_user'] = $user->get_id_user();
    $_SESSION['name'] = $user->get_firstname() . ' ' . $user->get_surname();
    $_SESSION['email'] = $user->get_email();
    $_SESSION['literature_table'] = $user->get_literature_table();
    $_SESSION['literature_cart'] = $user->get_literature_cart();
    $_SESSION['role'] = ($user->is_admin()) ? 'admin' : 'user';

    $update_user_logintime = include 'tables/update_users_logintime.php';

    $update_user_logintime($database_pdo, $user->get_id_user());

    return true;
};