<?php return function (\PDO $connection): array {

    $histroy_types = array(
        Tables\History::SHIFT_PROMOTE_SUCCESS,
        Tables\History::SHIFT_PROMOTE_ERROR,
        Tables\History::SHIFT_WITHDRAWN_SUCCESS,
        Tables\History::SHIFT_WITHDRAWN_ERROR
    );

    $shift_history_list = Tables\History::select_all($connection, $histroy_types);
    $sort_shift_history_list = array();

    foreach ($shift_history_list as $shift_history) {
        if(strpos($shift_history['type'], 'error') === false)
            $type = 'success';
        else
            $type = 'error';

        $sort_shift_history_list[$type][] = array(
            'datetime' => $shift_history['datetime'],
            'user' => $shift_history['name'],
            'description' => $shift_history['description']
        );
    }
    return $sort_shift_history_list;
};