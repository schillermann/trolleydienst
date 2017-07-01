<?php
return function (array $user_list): array {

    $user_promote_list = array();
    $user_promote_list['literature_table'] = array();
    $user_promote_list['literature_cart'] = array();

    if($_SESSION['is_literature_table'])
        $user_promote_list['literature_table'][$_SESSION['id_user']] = $_SESSION['name'];
    if($_SESSION['is_literature_cart'])
        $user_promote_list['literature_cart'][$_SESSION['id_user']] = $_SESSION['name'];

    foreach ($user_list as $user) {
        $user_name = $user['firstname'] . ' ' . $user['lastname'];
        if($user['is_literature_table'])
            $user_promote_list['literature_table'][$user['id_user']] = $user_name;
        if($user['is_literature_cart'])
            $user_promote_list['literature_cart'][$user['id_user']] = $user_name;
    }
    return $user_promote_list;
};