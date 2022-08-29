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
            ->where('is_deleted', 0)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getFirst($id) {
        return $this->db->select('*')
            ->from('tbl_arsip')
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOne($id) {
        return $this->db->select('*')
            ->from('tbl_arsip')
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneByID($id) {
        return $this->db->select('*')
            ->from('tbl_arsip')
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getFirstByNomor($nomor) {
        return $this->db->select('*')
            ->from('tbl_arsip')
            ->where('nomor', $nomor)
            ->where('is_deleted', 0)
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
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->count_all_results();
    }

    function countArsipByAdmin($adminID) {
        return $this->db->from($this->table)
            ->where('admin_id', $adminID)
            ->where('is_deleted', 0)
            ->count_all_results();
    }

    function getBatchByKlasifikasi($klasifikasiID, $page) {
        $offset = 10 * ($page - 1);
        return $this->db->select('*')
            ->from($this->table)
            ->where('klasifikasi_id', $klasifikasiID)
            ->where('is_deleted', 0)
            ->limit(10, $offset)
            ->order_by('id', 'desc')
            ->get()
            ->result_array();
    }

    function getPaginated($page) {
        $offset = 10 * ($page -1);
        return $this->db->select('*')
            ->from($this->table)
            ->where('is_deleted', 0)
            ->order_by('id', 'desc')
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }

    function publish($id) {
        return $this->db->update($this->table, [
            'is_published' => 1,
            'updated_at' => date('c')
        ], [
            'id' => $id
        ]);
    }

    function draft($id) {
        return $this->db->update($this->table, [
            'is_published' => 0,
            'updated_at' => date('c')
        ], [
            'id' => $id
        ]);
    }

    function getLast5() {
        return $this->db->select('*')
            ->from($this->table)
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->order_by('id', 'desc')
            ->limit(5)
            ->get()
            ->result_array();
    }

    function getLast30DaysPerDay($begin) {
        return $this->db->select('strftime("%Y-%m-%d", created_at) as date, count(id) as count')
            ->from($this->table)
            ->where('created_at IS NOT NULL', null, false)
            ->where('created_at >=', $begin)
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->group_by('date')
            ->get()
            ->result_array();
    }

    function delete($id) {
        return $this->db->update($this->table, [
            'is_deleted' => 1,
            'deleted_at' => date('c')
        ], [
            'id' => $id
        ]);
    }
}