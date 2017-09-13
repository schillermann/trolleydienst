<?php return function (\PDO $connection, int $id_shift, int $position,  int $promote_withdraw_id_user, string $actor_name): bool {

    $shift = Tables\Shifts::select($connection, $id_shift);
    $shift_type_name = Tables\ShiftTypes::select_name($connection, $shift['id_shift_type']);
    $name = Tables\Users::select_name($connection, $promote_withdraw_id_user);

    $promote_user_withdraw_success = Tables\ShiftUserMaps::delete($connection, $id_shift, $promote_withdraw_id_user, $position);

    $shift_datetime_from = new \DateTime($shift['datetime_from']);
    $shift_datetime_from_format = $shift_datetime_from->format('d.m.Y');

    if ($promote_user_withdraw_success) {
        $history_type = Tables\History::SHIFT_WITHDRAWN_SUCCESS;
        $message = 'Die ' . $shift_type_name . ' Schicht Bewerbung vom ' . $shift_datetime_from_format . ' Schicht ' . $position . ' für ' . $name . ' wurde zurück gezogen.';
    } else {
        $history_type = Tables\History::SHIFT_WITHDRAWN_ERROR;
        $message = 'Die ' . $shift_type_name . ' Schicht Bewerbung vom ' . $shift_datetime_from_format . ' Schicht ' . $position . ' für ' . $name . ' konnte nicht zurück gezogen werden!';
    }

    Tables\History::insert(
        $connection,
        $actor_name,
        $history_type,
        $message
    );

    return $promote_user_withdraw_success;
};