<?php
namespace Tables;

class Reports
{

	const TABLE_NAME = 'reports';

	static function create_table(\PDO $connection): bool
	{
		$sql =
			'CREATE TABLE `' . self::TABLE_NAME . '` (
				`id_report`	INTEGER PRIMARY KEY AUTOINCREMENT,
				`id_shift_type`	INTEGER NOT NULL,
				`name` TEXT NOT NULL,
				`route` TEXT NOT NULL,
				`book` INTEGER,
				`brochure` INTEGER,
				`bible`	INTEGER,
				`magazine` INTEGER,
				`tract`	INTEGER,
				`address` INTEGER,
				`talk` INTEGER,
				`note` TEXT,
				`shift_datetime_from` TEXT NOT NULL
            )';

		return ($connection->exec($sql) === false) ? false : true;
	}

	static function select_all(\PDO $connection, int $id_shift_type): array {

		$stmt = $connection->prepare(
			'SELECT id_report, name, shift_datetime_from, book, brochure, bible, magazine, tract, address, talk, note
            FROM ' . self::TABLE_NAME . '
            WHERE id_shift_type = :id_shift_type
            ORDER BY shift_datetime_from ASC'
		);

		$stmt->execute(array(':id_shift_type' => $id_shift_type));

		$result = $stmt->fetchAll();
		return ($result)? $result : array();
	}

	static function insert(\PDO $connection, \Models\Report $report): bool {
		$stmt = $connection->prepare(
			'INSERT INTO ' . self::TABLE_NAME . '
			(id_shift_type, name, route, book, brochure, bible, magazine, tract, address, talk, note, shift_datetime_from)
            VALUES (:id_shift_type, :name, :route, :book, :brochure, :bible, :magazine, :tract, :address, :talk, :note, :shift_datetime_from)'
		);

		$stmt->execute(
			array(
				':id_shift_type' => $report->get_id_shift_type(),
				':name' => $report->get_name(),
				':route' => $report->get_route(),
				':book' => $report->get_book(),
				':brochure' => $report->get_brochure(),
				':bible' => $report->get_bible(),
				':magazine' => $report->get_magazine(),
				':tract' => $report->get_tract(),
				':address' => $report->get_address(),
				':talk' => $report->get_talk(),
				':note' => $report->get_note(),
				':shift_datetime_from' => $report->get_shift_from()->format('Y-m-d H:i:s')
			)
		);
		return $stmt->rowCount() == 1;
	}
}