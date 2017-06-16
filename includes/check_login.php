<?php
return function (\PDO $database_pdo, string $username, string $password): bool {

    $user = Tables\Users::select_logindata_by_username_and_password($database_pdo, $username, $password);

    if(empty($user))
        return false;

    $_SESSION['id_user'] = (int)$user['id_user'];
    $_SESSION['name'] = $user['firstname'] . ' ' . $user['surname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['literature_table'] = Enum\Status::convert_to_enum($user['literature_table']);
    $_SESSION['literature_cart'] = Enum\Status::convert_to_enum($user['literature_cart']);
    $_SESSION['role'] = ($user['is_admin']) ? 'admin' : 'user';

    Tables\Users::update_login_time_by_id_user($database_pdo, $_SESSION['id_user']);

    return true;
};