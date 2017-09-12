<?php
namespace Models;

class Report {
	function __construct(
		int $id_user,
		int $id_shift_type,
		\DateTime $shift_from,
		int $book,
		int $brochure,
		int $bible,
		int $magazine,
		int $tract,
		int $address,
		int $talk,
		string $note) {

		$this->id_user = $id_user;
		$this->id_shift_type = $id_shift_type;
		$this->shift_from = $shift_from;
		$this->book = $book;
		$this->brochure = $brochure;
		$this->bible = $bible;
		$this->magazine = $magazine;
		$this->tract = $tract;
		$this->address = $address;
		$this->talk = $talk;
		$this->note = $note;
	}

	function get_id_user(): int {
		return $this->id_user;
	}
	function get_id_shift_type(): int {
		return $this->id_shift_type;
	}
	function get_shift_from(): \DateTime {
		return $this->shift_from;
	}
	function get_book(): int {
		return $this->book;
	}
	function get_brochure(): int {
		return $this->brochure;
	}
	function get_bible(): int {
		return $this->bible;
	}
	function get_magazine(): int {
		return $this->magazine;
	}
	function get_tract(): int {
		return $this->tract;
	}
	function get_address(): int {
		return $this->address;
	}
	function get_talk(): int {
		return $this->talk;
	}
	function get_note(): string {
		return $this->note;
	}

	protected $id_user, $id_shift_type, $shift_from, $book, $brochure, $bible, $magazine, $tract, $address, $talk, $note;
}