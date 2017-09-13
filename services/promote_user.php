<?php return function (\PDO $connection, int $id_shift, int $position, int $promote_id_user, string $actor_name): bool {

    $shift = Tables\Shifts::select($connection, $id_shift);
    $shift_type_name = Tables\ShiftTypes::select_name($connection, $shift['id_shift_type']);
    $name = Tables\Users::select_name($connection, $promote_id_user);

    $promote_user_success = Tables\ShiftUserMaps::insert($connection, $id_shift, $promote_id_user, $position);

    $shift_datetime_from = new \DateTime($shift['datetime_from']);
    $shift_datetime_from_format = $shift_datetime_from->format('d.m.Y');

    if ($promote_user_success) {
        $history_type = Tables\History::SHIFT_PROMOTE_SUCCESS;
        $message = 'Die ' . $shift_type_name . ' Schicht Bewerbung vom  ' . $shift_datetime_from_format . ' Schicht ' . $position . ' für ' . $name . ' wurde angenommen.';;
    } else {
        $history_type = Tables\History::SHIFT_PROMOTE_ERROR;
        $message = 'Die ' . $shift_type_name . ' Schicht Bewerbung vom  ' . $shift_datetime_from_format . ' Schicht ' . $position . '  für ' . $name . ' konnte nicht angenommen werden!';
    }

    Tables\History::insert(
        $connection,
        $actor_name,
        $history_type,
        $message
    );

    return $promote_user_success;
};