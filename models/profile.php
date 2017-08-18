<?php
namespace Models;

class Profile {
    /**
     * Profile constructor.
     * @param int $id_user
     * @param array $data With keys: firstname, lastname, email, username, phone, mobile, congregation_name, language, note_user
     */
    function __construct(int $id_user, array $data) {
        $this->id_user = $id_user;
        $this->firstname = (isset($data['firstname']))? $data['firstname'] : '';
        $this->lastname = (isset($data['lastname']))? $data['lastname'] : '';
        $this->email = (isset($data['email']))? $data['email'] : '';
        $this->username = (isset($data['username']))? $data['username'] : '';
        $this->phone = (isset($data['phone']))? $data['phone'] : '';
        $this->mobile = (isset($data['mobile']))? $data['mobile'] : '';
        $this->congregation_name = (isset($data['congregation_name']))? $data['congregation_name'] : '';
        $this->language = (isset($data['language']))? $data['language'] : '';
        $this->note_user = (isset($data['note_user']))? $data['note_user'] : '';
    }

    function  get_id_user(): int {
        return $this->id_user;
    }

    function get_firstname(): string {
        return $this->firstname;
    }

    function get_lastname(): string {
        return $this->lastname;
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

    function get_congregation_name(): string {
        return $this->congregation_name;
    }

    function get_language(): string {
        return $this->language;
    }

    function get_note_user(): string {
        return $this->note_user;
    }

    protected $id_user, $firstname, $lastname, $email, $username, $phone, $mobile, $congregation_name, $language, $note_user;
}