<?php
namespace Models;

class ShiftUser {

    function get_id_user(): int {
        return $this->id_user;
    }

    function get_firstname(): string {
        return $this->firstname;
    }

    function get_lastname(): string {
        return $this->lastname;
    }

    function get_mobile(): string {
        return $this->mobile;
    }

    function get_status(): int {
        return $this->status;
    }

    protected $id_user, $status, $shift_supervisor, $firstname, $lastname, $mobile;
}