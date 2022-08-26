<?php

class Klasifikasi_model extends CI_Model
{
    protected $table = 'tbl_klasifikasi';

    function store($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function getOne($id) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneByKode($kode) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('kode', $kode)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getBatch($page) {
        $offset = 10 * ($page - 1);
        return $this->db->select('*')
            ->from($this->table)
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }

}