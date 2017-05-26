<?php
namespace Models;

class User {

    function __construct() {
        $this->id_user = (int)$this->id_user;
        $this->active = !(bool)$this->active;
        $this->literature_table = \Enum\Status::convert_to_enum((int)$this->literature_table);
        $this->literature_cart = \Enum\Status::convert_to_enum((int)$this->literature_cart);
        $this->admin = (bool)$this->admin;
        $this->shift_max = (int)$this->shift_max;
        $this->phone = (empty($this->phone)) ? '' : $this->phone;
        $this->mobile = (empty($this->mobile)) ? '' : $this->mobile;
        $this->congregation = (empty($this->congregation)) ? '' : $this->congregation;
        $this->language = (empty($this->language)) ? '' : $this->language;
        $this->note_user = (empty($this->note_user)) ? '' : $this->note_user;
        $this->note_admin = (empty($this->note_admin)) ? '' : $this->note_admin;
    }

    function get_id_user(): int {
        return $this->id_user;
    }

    function is_active(): bool {
        return $this->active;
    }

    function set_active(bool $enabled) {
        $this->active = $enabled;
    }

    function get_firstname(): string {
        return $this->firstname;
    }

    function set_firstname(string $firstname) {
        $firstname_filtered = filter_var($firstname, FILTER_SANITIZE_STRING);
        if($firstname_filtered)
            $this->firstname = $firstname_filtered;
    }

    function get_surname(): string {
        return $this->surname;
    }

    function set_surname(string $surname) {
        $surname_filtered = filter_var($surname, FILTER_SANITIZE_STRING);
        if($surname_filtered)
            $this->surname = $surname_filtered;
    }

    function get_email(): string {
        return $this->email;
    }

    function set_email(string $email) {
        $email_filtered = filter_var($email, FILTER_VALIDATE_EMAIL);
        if($email_filtered)
            $this->email = $email_filtered;
    }

    function get_username(): string {
        return $this->username;
    }

    function set_username(string $username) {
        $username_filtered = preg_replace( '|[^a-z0-9 _.\-@]|i', '', $username);
        if(!empty($username_filtered))
            $this->username = $username_filtered;
    }

    function get_literature_table(): string {
        return $this->literature_table;
    }

    function set_literature_table(string $status) {
        if(\Enum\Status::is_valid($status))
            $this->literature_table = $status;
    }

    function get_literature_cart(): string {
        return $this->literature_cart;
    }

    function set_literature_cart(string $status) {
        if(\Enum\Status::is_valid($status))
            $this->literature_cart = $status;
    }

    function is_admin(): bool {
        return $this->admin;
    }

    function set_admin(bool $enabled) {
        $this->admin = $enabled;
    }

    function get_phone(): string {
        return $this->phone;
    }

    function set_phone(string $phone) {
        $phone_filtered = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        if($phone_filtered)
            $this->phone = $phone_filtered;
    }

    function get_mobile(): string {
        return $this->mobile;
    }

    function set_mobile(string $mobile) {
        $mobile_filtered = filter_var($mobile, FILTER_SANITIZE_NUMBER_INT);
        if($mobile_filtered)
            $this->mobile = $mobile_filtered;
    }

    function get_congregation(): string {
        return $this->congregation;
    }

    function set_congregation(string $congregation) {
        $congregation_filtered = filter_var($congregation, FILTER_SANITIZE_STRING);
        if($congregation_filtered)
            $this->congregation = $congregation_filtered;
    }

    function get_language(): string {
        return $this->language;
    }

    function set_language(string $language) {
        $language_filtered = filter_var($language, FILTER_SANITIZE_STRING);
        if($language_filtered)
            $this->language = $language_filtered;
    }

    function get_shift_max(): int {
        return $this->shift_max;
    }

    function set_shift_max(int $shift_max) {
        $this->shift_max = $shift_max;
    }

    function get_note_user(): string {
        return $this->note_user;
    }

    function set_note_user(string $note_user) {
        $note_user_filtered = filter_var($note_user, FILTER_SANITIZE_STRING);
        if($note_user_filtered)
            $this->note_user = $note_user_filtered;
    }

    function get_note_admin(): string {
        return $this->note_admin;
    }

    function set_note_admin(string $note_admin) {
        $note_admin_filtered = filter_var($note_admin, FILTER_SANITIZE_STRING);
        if($note_admin_filtered)
            $this->note_admin = $note_admin_filtered;
    }

    protected $id_user, $active, $firstname, $surname, $email, $username, $literature_table, $literature_cart, $admin, $phone, $mobile, $congregation, $language, $shift_max, $note_admin, $note_user;
}