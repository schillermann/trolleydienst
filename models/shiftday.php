<?php
namespace Models;

class ShiftDay {

    function __construct(int $id_shift_day = -1, int $type = -1, string $place = '', \DateTime $time_from = null, \DateTime $time_to = null, bool $is_extra_shift = false) {

        if($id_shift_day != -1)
            $this->id_shift_day = $id_shift_day;
        if($type != -1)
            $this->type = $type;
        if($time_from === null)
            $this->time_from = new \DateTime($time_from);
        else
            $this->time_from = $time_from;
        if($time_to === null)
            $this->time_to = new \DateTime($time_to);
        else
            $this->time_to = $time_to;

        if(!empty($place)) {
            $place_filtered = filter_var($place, FILTER_SANITIZE_STRING);
            if($place_filtered !== false)
                $this->place = $place_filtered;
        }
        if($this->is_extra_shift === null)
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

    function get_time_from(): \DateTime {
        return $this->time_from;
    }

    function get_time_to(): \DateTime {
        return $this->time_to;
    }

    function is_extra_shift(): bool {
        return $this->is_extra_shift;
    }

    protected $id_shift_day, $type, $place, $time_from, $time_to, $is_extra_shift;
}