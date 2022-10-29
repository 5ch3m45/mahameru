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
            ->where('is_deleted', 0)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneWithWhere($where) {
        return $this->db->select('*')
            ->from($this->table)
            ->where($where)
            ->where('is_deleted', 0)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getBatchByArsip($arsipID) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('arsip_id', $arsipID)
            ->where('is_deleted', 0)
            ->get()
            ->result_array();
    }

    function getAllByArsipID($arsipID) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('arsip_id', $arsipID)
            ->where('is_deleted', 0)
            ->get()
            ->result_array();
    }

    function getTop2LampiransByArsip($arsipID) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('arsip_id', $arsipID)
            ->where('is_deleted', 0)
            ->limit(2)
            ->get()
            ->result_array();
    }

    function countLampiranByArsip($arsipID) {
        return $this->db->from($this->table)
            ->where('arsip_id', $arsipID)
            ->where('is_deleted', 0)
            ->count_all_results();
    }

    function softDelete($id) {
        return $this->db->update($this->table, [
            'is_deleted' => 1,
            'deleted_at' => date('c')
        ], [
            'id' => $id
        ]);
    }
}