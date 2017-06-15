<?php
return function (\PDO $database, int $days_max, array $types): array {

    $stmt_date_list = $database->prepare(
        'SELECT terminnr AS id_shift_day, art AS type, ort AS place,
        termin_von AS time_from,
        termin_bis AS time_to,
        DATEDIFF(termin_von,curdate()) AS datetime_diff,
        coalesce(sonderschicht,0) as shift_extra
        FROM termine
        WHERE art IN(' . implode(',', $types) . ')
        AND (datediff(curdate(),termin_von) <= :date_max_days )
        ORDER BY termin_von ASC'
    );

    $stmt_date_list->execute(
        array(':date_max_days' => $days_max)
    );
    return $stmt_date_list->fetchAll(PDO::FETCH_CLASS, 'Models\ShiftDay');
};