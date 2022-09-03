<?php

class Aduan_model extends CI_Model
{
    protected $table = 'tbl_aduan';

    function getOneByKode($kode) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('kode', $kode)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneByID($id) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function getPaginated($page) {
        $offset = 10 * ($page -1);
        return $this->db->select('*')
            ->from($this->table)
            ->order_by('id', 'desc')
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }

    function delete($id) {
        return $this->delete($this->table, ['id', $id]);
    }
}