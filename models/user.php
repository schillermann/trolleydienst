<?php
namespace Models;

class User {

    function __construct() {
        $this->id_user = (int)$this->id_user;
        $this->literature_table = (bool)$this->literature_table;
        $this->literature_cart = (bool)$this->literature_cart;
        $this->admin = (bool)$this->admin;
    }

    function get_id_user(): int {
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

    function is_literature_table(): bool {
        return $this->literature_table;
    }

    function is_literature_cart(): bool {
        return $this->literature_cart;
    }

    function is_admin(): bool {
        return $this->admin;
    }

    protected $id_user, $firstname, $surname, $email, $literature_table, $literature_cart, $admin;
}