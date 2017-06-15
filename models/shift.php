<?php
namespace Models;

class Shift {

    function __construct(int $id_shift = -1, \DateTime $time_from = null, \DateTime $time_to = null, int $id_shift_day = -1) {

        if($id_shift !== -1)
            $this->id_shift = $id_shift;
        if($time_from !== null)
            $this->time_from = $time_from;
        else
            $this->time_from = new \DateTime($this->time_from);
        if($time_to !== null)
            $this->time_to = $time_to;
        else
            $this->time_to = new \DateTime($this->time_to);
        if($id_shift_day !== -1)
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