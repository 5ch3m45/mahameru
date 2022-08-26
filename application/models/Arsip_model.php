<?php

class Arsip_model extends CI_Model
{
    protected $table = 'tbl_arsip';

    function create($data) {
        $this->db->insert('tbl_arsip', $data);
        return $this->db->insert_id();
    }

    function first($id) {
        return $this->db->select('*')
            ->from('tbl_arsip')
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getFirst($id) {
        return $this->db->select('*')
            ->from('tbl_arsip')
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getFirstByNomor($nomor) {
        return $this->db->select('*')
            ->from('tbl_arsip')
            ->where('nomor', $nomor)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function update($id, $data) {
        return $this->db->update('tbl_arsip', $data, ['id' => $id]);
    }

    function countArsipByKlasifikasi($klasifikasiID) {
        return $this->db->from($this->table)
            ->where('klasifikasi_id', $klasifikasiID)
            ->count_all_results();
    }

    function getBatchByKlasifikasi($klasifikasiID, $page) {
        $offset = 10 * ($page - 1);
        return $this->db->select('*')
            ->from($this->table)
            ->where('klasifikasi_id', $klasifikasiID)
            ->limit(10, $offset)
            ->orderBy('id', 'desc')
            ->get()
            ->result_array();
    }

    function getBatch($page) {
        $offset = 10 * ($page -1);
        return $this->db->select('*')
            ->from($this->table)
            ->order_by('id', 'desc')
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }
}