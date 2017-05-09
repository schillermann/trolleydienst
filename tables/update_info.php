<?php
return function (\PDO $database_pdo, int $id_file, string $file_label, int $file_type): bool {

    $stmt_file = $database_pdo->prepare(
        'UPDATE newsletter
            SET Bezeichnung = :file_label, newsletter_typ = :file_type
            WHERE ID = :id_file'
    );

    return $stmt_file->execute(
        array(
            ':file_label' => $file_label,
            ':file_type' => $file_type,
            ':id_file' => $id_file
        )
    );
};