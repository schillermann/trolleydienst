<?php
return function (\PDO $database_pdo): array {

    $stmt_file_list = $database_pdo->query(
        'SELECT ID AS id_file, Bezeichnung AS file_label, Dateiname AS file_name, ServerPfadname AS file_hash, newsletter_typ AS file_type
        FROM newsletter
        ORDER BY newsletter_typ'
    );

    $file_list = array();
    $file_list[-1] = array();
    $file_list[0] = array();
    $file_list[1] = array();
    $file_list[2] = array();

    while($next_file = $stmt_file_list->fetchObject('Models\File'))
        $file_list[$next_file->get_file_type()][] = $next_file;

    return $file_list;
};