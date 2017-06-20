<?php
namespace Models;

class Shift {

    function __construct(int $id_shift, int $id_shift_day, \DateTime $time_from, \DateTime $time_to) {

        $this->id_shift = $id_shift;
        $this->time_from = $time_from;
        $this->time_to = $time_to;
        $this->id_shift_day = $id_shift_day;
    }

    function get_id_shift(): int {
        return $this->id_shift;
    }

    function get_id_shift_day(): int {
        return $this->id_shift_day;
    }

    function get_time_from(): \DateTime {
        return $this->time_from;
    }

    function get_time_to(): \DateTime {
        return $this->time_to;
    }

    protected $id_shift, $id_shift_day, $time_from, $time_to;
}