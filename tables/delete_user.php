<?php
return function (\PDO $database_pdo, int $id_user): bool {

    $stmt_user_delete = $database_pdo->prepare(
        'DELETE FROM teilnehmer WHERE teilnehmernr = :id_user'
    );

    return $stmt_user_delete->execute(
        array(':id_user' => $id_user)
    );
};