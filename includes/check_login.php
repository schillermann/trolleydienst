<?php
return function (\PDO $database, string $username, string $password): bool {

    $user_select = include 'tables/select_user.php';

    $user = $user_select($database, $username, $password);

    if ($user) {
        $_SESSION['id_user'] = $user->get_id_user();
        $_SESSION['name'] = $user->get_firstname() . ' ' . $user->get_surname();
        $_SESSION['email'] = $user->get_email();
        $_SESSION['literature_table'] = ($user->is_literature_table()) ? 1 : 0;
        $_SESSION['literature_cart'] = ($user->is_literature_cart()) ? 1 : 0;
        $_SESSION['role'] = ($user->is_admin()) ? 'admin' : 'user';

        $update_user_logintime = include 'tables/update_user_logintime.php';

        $update_user_logintime($database, $user->get_id_user());

        return TRUE;
    }
    return FALSE;
};