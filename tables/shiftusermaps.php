<?php
namespace Tables;

class ShiftUserMaps {
    static function select_all(\PDO $connection, int $id_shift_day, int $id_shift): array {
        $stmt = $connection->prepare(
            'SELECT SchTeil.teilnehmernr AS id_user, SchTeil.status AS status,
            SchTeil.isschichtleiter AS shift_supervisor, muser.vorname AS firstname,
            muser.nachname AS surname, muser.Handy AS mobile
            FROM schichten_teilnehmer SchTeil
            LEFT OUTER JOIN teilnehmer muser
            ON SchTeil.teilnehmernr = muser.teilnehmernr
            WHERE SchTeil.terminnr = :id_shift_day
            AND SchTeil.schichtnr = :id_shift
            ORDER BY SchTeil.isschichtleiter DESC'
        );

        $stmt->execute(
            array(
                ':id_shift_day' => $id_shift_day,
                ':id_shift' => $id_shift
            )
        );

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }
}