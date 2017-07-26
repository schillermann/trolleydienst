<?php
namespace Models;

class ShiftDay {

    function __construct(
        int $id_shift_day,
        int $id_shift_type,
        string $place,
        \DateTime $datetime_from,
        int $number,
        float $hours_per_shift,
        string $color_hex
    ) {
        $this->id_shift_day = $id_shift_day;
        $this->id_shift_type = $id_shift_type;
        $this->place = $place;
        $this->datetime_from = $datetime_from;
        $this->number = $number;
        $this->hours_per_shift = $hours_per_shift;
        $this->color_hex = $color_hex;
    }

    function get_id_shift_day(): int {
        return $this->id_shift_day;
    }

    function get_id_shift_type(): int {
        return $this->id_shift_type;
    }

    function get_place(): string {
        return $this->place;
    }

    function get_datetime_from(): \DateTime {
        return $this->datetime_from;
    }

    function get_number(): int {
        return $this->number;
    }

    function get_hours_per_shift(): float {
        return $this->hours_per_shift;
    }

    function get_color_hex(): string {
        return $this->color_hex;
    }

    protected $id_shift_day, $id_shift_type, $place, $datetime_from, $number, $hours_per_shift, $color_hex;
}