<?php
namespace Models;

class File {

    function __construct() {
        $this->id_file = (int)$this->id_file;
        $this->file_type = (int)$this->file_type;
    }

    function get_id_file(): int {
        return $this->id_file;
    }

    function get_file_label():string {
        return $this->file_label;
    }

    function get_file_name():string {
        return $this->file_name;
    }

    function get_file_hash():string {
        return$this->file_hash;
    }

    function get_file_type(): int {
        return $this->file_type;
    }

    protected $id_file, $file_label, $file_name, $file_hash, $file_type;
}