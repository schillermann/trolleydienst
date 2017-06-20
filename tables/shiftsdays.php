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

    /**
     * @param \PDO $connection
     * @param \Models\ShiftDay $shift_day
     * @return int Shiftday ID
     */
    static function insert(\PDO $connection, \Models\ShiftDay $shift_day): int {
        $smtp_next_id_shiftday = $connection->query(
            'SELECT coalesce(Max(terminnr),0) + 1
            FROM termine'
        );

        $id_shiftday = (int)$smtp_next_id_shiftday->fetchColumn();

        $smtp_insert_date = $connection->prepare(
            'INSERT INTO termine (terminnr, art, ort, termin_von, termin_bis, sonderschicht)
		    VALUES (:id_shiftday, :type, :place, :date_from, :date_to, :extra_shift)'
        );

        $smtp_insert_date->execute(
            array(
                ':id_shiftday' => $id_shiftday,
                ':type' => $shift_day->get_type(),
                ':place' => $shift_day->get_place(),
                ':date_from' => $shift_day->get_datetime_from()->format('Y-m-d H:i:s'),
                ':date_to' => $shift_day->get_datetime_to()->format('Y-m-d H:i:s'),
                ':extra_shift' => ($shift_day->is_extra_shift()) ? 1 : 0
            )
        );

        return ($smtp_insert_date->rowCount() == 1)? $id_shiftday : 0;
    }
}