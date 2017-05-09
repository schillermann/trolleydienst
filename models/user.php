<?php
namespace Models;

class User {

    function __construct() {
        $this->id_user = (int)$this->id_user;
        $this->literature_table = (bool)$this->literature_table;
        $this->literature_cart = (bool)$this->literature_cart;
        $this->admin = (bool)$this->admin;
        $this->shift_max = (int)$this->shift_max;
    }

    function get_id_user(): int {
        return $this->id_user;
    }

    function set_id_user(int $number) {
        $this->id_user = $number;
    }

    function get_firstname(): string {
        return $this->firstname;
    }

    function set_firstname(string $value) {
        $this->firstname = filter_var($value, FILTER_SANITIZE_STRING);
    }

    function get_surname(): string {
        return $this->surname;
    }

    function set_surname(string $value) {
        $this->surname = filter_var($value, FILTER_SANITIZE_STRING);
    }

    function get_email(): string {
        return $this->email;
    }

    function set_email(string $value) {
        $email = filter_var($value, FILTER_VALIDATE_EMAIL);
        if($email)
            $this->email = $email;
    }

    function get_username(): string {
        return $this->username;
    }

    function is_literature_table(): bool {
        return $this->literature_table;
    }

    function is_literature_cart(): bool {
        return $this->literature_cart;
    }

    function is_admin(): bool {
        return $this->admin;
    }

    function get_phone(): string {
        return $this->phone;
    }

    function set_phone(string $number) {
        $this->phone = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    }

    function get_mobile(): string {
        return $this->mobile;
    }

    function set_mobile(string $number) {
        $this->mobile = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    }

    function get_shift_max(): int {
        return $this->shift_max;
    }

    function set_shift_max(int $number) {
        $this->shift_max = $number;
    }

    function get_note(): string {
        return $this->note;
    }

    function set_note(string $value) {
        $this->note = filter_var($value, FILTER_SANITIZE_STRING);
    }

    protected $id_user, $firstname, $surname, $email, $username, $literature_table, $literature_cart, $admin, $phone, $mobile, $shift_max, $note;
}