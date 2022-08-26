<?php

class Lampiran_model extends CI_Model
{
    protected $table = 'tbl_lampiran';

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

    function getBatchByArsip($arsipID) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('arsip_id', $arsipID)
            ->get()
            ->result_array();
    }

    function getTop2LampiransByArsip($arsipID) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('arsip_id', $arsipID)
            ->limit(2)
            ->get()
            ->result_array();
    }

    function countLampiranByArsip($arsipID) {
        return $this->db->from($this->table)
            ->where('arsip_id', $arsipID)
            ->count_all_results();
    }
}