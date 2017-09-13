<?php return function (\PDO $connection, \DateTime $report_from, \DateTime $report_to, int $id_shift_type, string $name): array {

	$report_list = array();

	foreach (Tables\Reports::select_all($connection, $report_from, $report_to, $id_shift_type, $name) as $report) {

		$shift_datetime_from = new \DateTime($report['shift_datetime_from']);
		$get_weekday = include 'helpers/get_weekday.php';

		$report_list[$report['id_report']] = array(
			'name' => $report['name'],
			'route' => $report['route'],
			'day' => $get_weekday($shift_datetime_from),
			'datetime' => $shift_datetime_from->format('d.m.Y H:i'),
			'book' => (int)$report['book'],
			'brochure' => (int)$report['brochure'],
			'bible' => (int)$report['bible'],
			'magazine' => (int)$report['magazine'],
			'tract' => (int)$report['tract'],
			'address' => (int)$report['address'],
			'talk' => (int)$report['talk'],
			'note' => $report['note']
		);
	}
	return $report_list;
} ?>