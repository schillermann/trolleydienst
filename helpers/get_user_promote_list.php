<?php
return function (array $user_list): array {

    $user_promote_list = array();
    $user_promote_list['literature_table'] = array();
    $user_promote_list['literature_cart'] = array();

    if($_SESSION['literature_table'] != Enum\Status::INACTIVE)
        $user_promote_list['literature_table'][$_SESSION['id_user']] = $_SESSION['name'];
    if($_SESSION['literature_cart'] != Enum\Status::INACTIVE)
        $user_promote_list['literature_cart'][$_SESSION['id_user']] = $_SESSION['name'];

    foreach ($user_list as $user) {
        $user_name = $user['firstname'] . ' ' . $user['surname'];
        if((int)$user['literature_table'] == 1)
            $user_promote_list['literature_table'][$user['id_user']] = $user_name;
        if((int)$user['literature_cart'] == 1)
            $user_promote_list['literature_cart'][$user['id_user']] = $user_name;
    }
    return $user_promote_list;
};