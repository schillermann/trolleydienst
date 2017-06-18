<?php
namespace Tables;

class ShiftsDays {
    static function select_all(\PDO $connection, int $days_max, array $types): array {
        $stmt = $connection->prepare(
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

        $stmt->execute(
            array(':date_max_days' => $days_max)
        );
        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }
}