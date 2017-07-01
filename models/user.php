<?php
namespace Models;

class User {

    function __construct(
        int $id_user,
        string $firstname,
        string $lastname,
        string $email,
        string $username,
        string $password,
        bool $is_admin = false,
        bool $is_active = true,
        bool $is_literature_cart = true,
        bool $is_literature_table = true,
        string $phone = null,
        string $mobile = null,
        string $congregation = null,
        string $language = null,
        string $note_admin = null,
        string $note_user = null
    ) {
        $this->id_user = $id_user;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->username = $username;
        $this->password = md5($password);
        $this->is_admin = $is_admin;
        $this->is_active = $is_active;
        $this->is_literature_cart = $is_literature_cart;
        $this->is_literature_table = $is_literature_table;
        $this->phone = $phone;
        $this->mobile = $mobile;
        $this->congregation = $congregation;
        $this->language = $language;
        $this->note_admin = $note_admin;
        $this->note_user = $note_user;
    }

    function get_id_user(): int {
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

    function get_password(): string {
        return $this->password;
    }

    function is_active(): bool {
        return $this->is_active;
    }

    function is_literature_table(): bool {
        return $this->is_literature_table;
    }

    function is_literature_cart(): bool {
        return $this->is_literature_cart;
    }

    function is_admin(): bool {
        return $this->is_admin;
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

    function get_note_user(): string {
        return $this->note_user;
    }

    function get_note_admin(): string {
        return $this->note_admin;
    }

    protected $id_user, $firstname, $lastname, $email, $username, $password, $is_admin, $is_active, $phone, $mobile;
    protected $congregation, $language, $note_user, $note_admin, $is_literature_cart, $is_literature_table;
}