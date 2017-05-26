<?php
return function (\PDO $database_pdo): array {

    $stmt_user_list = $database_pdo->query(
        'SELECT teilnehmernr AS id_user, vorname AS firstname, nachname AS surname, email, status AS active, username, infostand AS literature_table, trolley AS literature_cart, admin  
        FROM teilnehmer'
    );

    $user_list = array();

    while($next_user = $stmt_user_list->fetchObject('Models\User'))
        $user_list[] = $next_user;

    return $user_list;
};