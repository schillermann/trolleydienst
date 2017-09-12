<?php
if(!isset($_GET['id_shift_type'])) {
	header('location: info.php');
	return;
}
$placeholder = require 'includes/init_page.php';
$placeholder['id_shift_type'] = (int)$_GET['id_shift_type'];

if(isset($_POST['save'])) {
	$date_from = include 'filters/post_date_from.php';

	$merge_date_and_time = include 'modules/merge_date_and_time.php';
	$shift_datetime_from = $merge_date_and_time($date_from, $_POST['time_from']);

	$report = new Models\Report(
		(int)$_POST['id_user'],
		$placeholder['id_shift_type'],
		$shift_datetime_from,
		(int)$_POST['book'],
		(int)$_POST['brochure'],
		(int)$_POST['bible'],
		(int)$_POST['magazine'],
		(int)$_POST['tract'],
		(int)$_POST['address'],
		(int)$_POST['talk'],
		include 'filters/post_note.php'
	);
	if(Tables\Reports::insert($database_pdo, $report))
		$placeholder['message']['success'] = 'Dein Bericht wurde gespeichert.';
	else
		$placeholder['message']['error'] = 'Dein Bericht konnte nicht gespeichert werden!';
}

$placeholder['user_list'] = Tables\Users::select_all($database_pdo);
$placeholder['shifttype_list'] = Tables\ShiftTypes::select_all($database_pdo);


$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);