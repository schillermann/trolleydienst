<?php
namespace Models;

class ShiftDayShiftList {

    function __construct(ShiftDay $shiftday) {
        $this->shiftday = $shiftday;
    }

    function get_shiftday(): ShiftDay {
        return $this->shiftday;
    }

    function add_shift_user_list(ShiftUserList $shift) {
        $this->shift_user_list[] = $shift;
    }

    function get_iterator_shift_user_list(): \ArrayIterator {
        return new \ArrayIterator( $this->shift_user_list );
    }

    protected  $shiftday, $shift_user_list = array();
}