<?php
namespace Models;

class Schedule {

    function __construct() {
        $this->datetime_from = new \DateTime($this->datetime_from);
        $this->datetime_to = new \DateTime($this->datetime_to);
    }

    function get_schedule_id(): int {
        return $this->id_schedule;
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

    function add_shift(Shift $shift) {
        $this->shift_list[] = $shift;
    }

    function get_iterator_shift(): \ArrayIterator {
        return new \ArrayIterator( $this->shift_list );
    }

    protected  $id_schedule, $type, $place, $datetime_from, $datetime_to, $datetime_diff, $shift_extra, $shift_list = array();
}