<?php

class Admin_model extends CI_Model
{
    protected $table = 'users';

    function getFirst($id) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneByID($id) {
        return $this->db->select('id, name, email, image, last_login')
            ->from($this->table)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getPaginated($page) {
        $offset = 10 * ($page-1);
        return $this->db->select('id, name, email, image, last_login')
            ->from($this->table)
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }

    function getOneByEmail($email) {
        return $this->db->select('id, email')
            ->from($this->table)
            ->where('email', $email)
            ->limit(1)
            ->get()
            ->row_array();
    }
}