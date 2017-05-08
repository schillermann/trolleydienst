<?php
return function (\PDO $database_pdo, int $id_file): bool {

    $stmt_file = $database_pdo->prepare(
        'DELETE FROM newsletter WHERE ID = :id_file'
    );

    return $stmt_file->execute(
        array(':id_file' => $id_file)
    );
};