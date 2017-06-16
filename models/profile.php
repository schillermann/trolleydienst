<?php
namespace Models;

class Profile {
    /**
     * Profile constructor.
     * @param int $id_user
     * @param array $data With keys: firstname, surname, email, username, phone, mobile, congregation, language, shift_max, note_user
     */
    function __construct(int $id_user, array $data) {
        $this->id_user = $id_user;
        $this->firstname = (isset($data['firstname']))? $data['firstname'] : '';
        $this->surname = (isset($data['surname']))? $data['surname'] : '';
        $this->email = (isset($data['email']))? $data['email'] : '';
        $this->username = (isset($data['username']))? $data['username'] : '';
        $this->phone = (isset($data['phone']))? $data['phone'] : '';
        $this->mobile = (isset($data['mobile']))? $data['mobile'] : '';
        $this->congregation = (isset($data['congregation']))? $data['congregation'] : '';
        $this->language = (isset($data['language']))? $data['language'] : '';
        $this->shift_max = (isset($data['shift_max']))? (int)$data['shift_max'] : 0;
        $this->note_user = (isset($data['note_user']))? $data['note_user'] : '';
    }

    function  get_id_user(): int {
        return $this->id_user;
    }

    function get_firstname(): string {
        return $this->firstname;
    }

    function get_surname(): string {
        return $this->surname;
    }

    function get_email(): string {
        return $this->email;
    }

    function get_username(): string {
        return $this->username;
    }

    function get_phone(): string {
        return $this->phone;
    }

    function get_mobile(): string {
        return $this->mobile;
    }

    function get_congregation(): string {
        return $this->congregation;
    }

    function get_language(): string {
        return $this->language;
    }

    function get_shift_max(): int {
        return $this->shift_max;
    }

    function get_note_user(): string {
        return $this->note_user;
    }

    protected $id_user, $firstname, $surname, $email, $username, $phone, $mobile, $congregation, $language, $shift_max, $note_user;
}