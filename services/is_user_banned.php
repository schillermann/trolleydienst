<?php return function (\PDO $connection) {

	$user_ip_address = include 'modules/get_ip_address.php';

	$ban_and_updated = Tables\AccessFails::select_ban_and_updated($connection, $user_ip_address);

	$updated_next_day = $ban_and_updated['updated']->modify('+1 day');
	$ban_next_5_minutes = $ban_and_updated['ban']->modify('+5 minutes');
	$datetime_null = new \DateTime('0000-00-00 00:00:00');

	$datetime_now = new \DateTime('now', new DateTimezone('Europe/Berlin'));
	if(
		$datetime_now > $updated_next_day ||
		($ban_next_5_minutes != $datetime_null && $datetime_now > $ban_next_5_minutes)
	)
		Tables\AccessFails::delete($connection, $user_ip_address);

	$number_of_fail = Tables\AccessFails::select_fail($connection, $user_ip_address);

	if($number_of_fail == 0) {
		Tables\AccessFails::insert($connection, $user_ip_address);
		return false;
	}

	if($number_of_fail > 5) {
		Tables\AccessFails::update_ban($connection, $user_ip_address);
		return true;
	}

	Tables\AccessFails::update_fail($connection, $user_ip_address);
	return false;
};