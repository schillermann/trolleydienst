<?php
namespace Models;

class Shift {

    function __construct() {
        $this->datetime_from = new \DateTime($this->datetime_from);
        $this->datetime_to = new \DateTime($this->datetime_to);
    }

    function get_id_shift(): int {
        return $this->id_shift;
    }

    function get_id_schedule(): int {
        return $this->id_schedule;
    }

    function get_datetime_from(): \DateTime {
        return $this->datetime_from;
    }

    function get_datetime_to(): \DateTime {
        return $this->datetime_to;
    }

    function add_shift_user(ShiftUser $shift_user) {
        $this->shift_user_list[] = $shift_user;
    }

    function get_iterator_user(): \ArrayIterator {
        return new \ArrayIterator( $this->shift_user_list );
    }

    function count(): int {
        return count($this->shift_user_list);
    }

    protected $id_shift, $id_schedule, $datetime_from, $datetime_to, $shift_user_list = array();
}