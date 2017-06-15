<?php
namespace Models;

class ShiftUserList {

    function __construct(Shift $shift) {
        $this->shift = $shift;
    }

    function get_shift(): Shift {
        return $this->shift;
    }

    function add_user_to_shift(ShiftUser $shift_user) {
        $this->shift_user_list[] = $shift_user;
    }

    function get_iterator_user(): \ArrayIterator {
        return new \ArrayIterator( $this->shift_user_list );
    }

    function count(): int {
        return count($this->shift_user_list);
    }

    protected $shift, $shift_user_list = array();
}