<?php
namespace Models;

class ShiftDay {

    function __construct(int $id_shift_day, int $type, string $place, \DateTime $datetime_from , \DateTime $datetime_to, bool $is_extra_shift) {

        $this->id_shift_day = $id_shift_day;
        $this->type = $type;
        $this->datetime_from = $datetime_from;
        $this->datetime_to = $datetime_to;
        $this->place = $place;
        $this->is_extra_shift = $is_extra_shift;
    }

    function get_id_shift_day(): int {
        return $this->id_shift_day;
    }

    function get_type(): int {
        return $this->type;
    }

    function get_place(): string {
        return $this->place;
    }

    function get_datetime_from(): \DateTime {
        return $this->datetime_from;
    }

    function get_datetime_to(): \DateTime {
        return $this->datetime_to;
    }

    function is_extra_shift(): bool {
        return $this->is_extra_shift;
    }

    protected $id_shift_day, $type, $place, $datetime_from, $datetime_to, $is_extra_shift;
}