<?php return function (\PDO $connection, int $id_shift, int $position, int $id_user): bool {

    $shift = Tables\Shifts::select($connection, $id_shift);
    $shift_type_name = Tables\ShiftTypes::select_name($connection, $shift['id_shift_type']);
    $user_name = Tables\Users::select_name($connection, $id_user);

    $promote_user_success = Tables\ShiftUserMaps::insert($connection, $id_shift, $position, $id_user);

    $shift_datetime_from = new \DateTime($shift['datetime_from']);
    $shift_datetime_from_format = $shift_datetime_from->format('d.m.Y');

    if ($promote_user_success) {

		$user_list_from_shift_postion = Tables\ShiftUserMaps::select_all_with_id_shift_and_position($connection, $id_shift, $position);
    	foreach ($user_list_from_shift_postion as $user) {
    		if($user['id_user'] == $id_user)
    			continue;

			$get_template_email_user_promote = include 'services/get_email_template.php';
			$email_template = $get_template_email_user_promote($connection, Tables\Templates::EMAIL_USER_PROMOTE);

			$replace_with = array(
				'NAME' => $user['name'],
				'APPLICANT_NAME' => $user_name,
				'SHIFT_DATE' => $shift_datetime_from_format
			);

			$email_template_message = strtr($email_template['message'], $replace_with);

			$send_mail_plain = include 'modules/send_mail_plain.php';
			if(!$send_mail_plain($user['email'], $email_template['subject'], $email_template_message)) {
				Tables\History::insert(
					$connection,
					$_SESSION['name'],
					Tables\History::SYSTEM_ERROR,
					'Die Bewerber Info E-Mail konnte nicht an ' . $user['name'] . ' mit der E-Mail Adresse ' . $user['email'] . ' verschickt werden!'
				);
			}

		}

        $history_type = Tables\History::SHIFT_PROMOTE_SUCCESS;
        $message = 'Die ' . $shift_type_name . ' Schicht Bewerbung vom  ' . $shift_datetime_from_format . ' Schicht ' . $position . ' für ' . $user_name . ' wurde angenommen.';
    } else {
        $history_type = Tables\History::SHIFT_PROMOTE_ERROR;
        $message = 'Die ' . $shift_type_name . ' Schicht Bewerbung vom  ' . $shift_datetime_from_format . ' Schicht ' . $position . '  für ' . $user_name . ' konnte nicht angenommen werden!';
    }

    Tables\History::insert(
        $connection,
		$_SESSION['name'],
        $history_type,
        $message
    );

    return $promote_user_success;
};