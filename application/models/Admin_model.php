<?php

class Admin_model extends CI_Model
{
    protected $table = 'tbl_admin';

    function getFirst($id) {
        return $this->db->select('*')
            ->from('tbl_admin')
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneByID($id) {
        return $this->db->select('id, nama, email, foto, last_login')
            ->from($this->table)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getPaginated($page) {
        $offset = 10 * ($page-1);
        return $this->db->select('id, nama, email, foto, last_login')
            ->from($this->table)
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }
}