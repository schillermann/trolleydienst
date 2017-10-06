<?php
return function (\PDO $connection, int $id_shift, int $position,  int $id_user): bool {

	$delete_application_success = Tables\ShiftUserMaps::delete($connection, $id_shift, $position, $id_user);

	$shift = Tables\Shifts::select($connection, $id_shift);
	$shift_type_name = Tables\ShiftTypes::select_name($connection, $shift['id_shift_type']);
	$applicant_name = Tables\Users::select_name($connection, $id_user);
	$shift_datetime_from = new \DateTime($shift['datetime_from']);
	$shift_datetime_from_format = $shift_datetime_from->format('d.m.Y');

	if ($delete_application_success) {
		$history_type = Tables\History::SHIFT_WITHDRAWN_SUCCESS;
		$message = 'Die ' . $shift_type_name . ' Schicht Bewerbung vom ' . $shift_datetime_from_format . ' Schicht ' . $position . ' für ' . $applicant_name . ' wurde zurück gezogen.';
	} else {
		$history_type = Tables\History::SHIFT_WITHDRAWN_ERROR;
		$message = 'Die ' . $shift_type_name . ' Schicht Bewerbung vom ' . $shift_datetime_from_format . ' Schicht ' . $position . ' für ' . $applicant_name . ' konnte nicht zurück gezogen werden!';
	}

	Tables\History::insert(
		$connection,
		$_SESSION['name'],
		$history_type,
		$message
	);

	return $delete_application_success;
};