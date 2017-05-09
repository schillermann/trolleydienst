<?php
return function (\PDO $database_pdo, int $id_file): Models\File {

    $stmt_file = $database_pdo->prepare(
        'SELECT ID AS id_file, Bezeichnung AS file_label, Dateiname AS file_name, ServerPfadname AS file_hash, coalesce(newsletter_typ,0) AS file_type
            FROM newsletter
            WHERE ID = :id_file'
    );

    $stmt_file->execute(
        array(':id_file' => $id_file)
    );
    return $stmt_file->fetchObject('Models\File');
};