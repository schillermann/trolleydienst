<?php
namespace Models;

class AppointmentShiftList {

    function __construct(Appointment $appointment) {
        $this->appointment = $appointment;
    }

    function get_appointment(): Appointment {
        return $this->appointment;
    }

    function add_shift_user_list(ShiftUserList $shift) {
        $this->shift_user_list[] = $shift;
    }

    function get_iterator_shift_user_list(): \ArrayIterator {
        return new \ArrayIterator( $this->shift_user_list );
    }

    protected  $appointment, $shift_user_list = array();
}