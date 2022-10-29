<?php

class Arsip_model extends CI_Model
{
    protected $table = 'tbl_arsip';

    function create($data) {
        $this->db->insert('tbl_arsip', $data);
        return $this->db->insert_id();
    }

    function getOneByID($id, $is_admin = FALSE) {
        $where = [
            'id' => $id,
            'is_deleted' => 0
        ];

        if(!$is_admin) {
            $where = array_merge($where, [
                'level' => '2'
            ]);
        }

        return $this->db->select('*')
            ->from($this->table)
            ->where($where)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneByNomor($nomor, $is_admin = FALSE) {
        $where = [
            'nomor' => $nomor,
            'is_deleted' => 0
        ];

        if(!$is_admin) {
            $where = array_merge($where, [
                'level' => '2'
            ]);
        }

        return $this->db->select('*')
            ->from($this->table)
            ->where($where)
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

    function getBatchByKlasifikasi($klasifikasiID, $page, $is_admin = FALSE) {
        $where = [
            'klasifikasi_id' => $klasifikasiID,
            'is_deleted' => 0
        ];

        if(!$is_admin) {
            $where = array_merge($where, [
                'level' => '2'
            ]);
        }

        $offset = 10 * ($page - 1);
        return $this->db->select('*')
            ->from($this->table)
            ->where($where)
            ->limit(10, $offset)
            ->order_by('id', 'desc')
            ->get()
            ->result_array();
    }

    function getPaginated($page, $is_admin = FALSE) {
        $where = [
            'is_deleted' => 0
        ];

        if(!$is_admin) {
            $where = array_merge($where, [
                'level' => '2'
            ]);
        }

        $offset = 10 * ($page -1);
        return $this->db->select('*')
            ->from($this->table)
            ->where($where)
            ->order_by('id', 'desc')
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }

    function getPaginatedPublic($page, $is_admin = FALSE) {
        $where = [
            'is_deleted' => 0
        ];

        if(!$is_admin) {
            $where = array_merge($where, [
                'level' => '2'
            ]);
        }

        $offset = 10 * ($page -1);
        return $this->db->select('id, nomor, informasi, pencipta, tanggal, klasifikasi_id')
            ->from($this->table)
            ->where($where)
            ->where('is_published', 1)
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

    function getLast5($is_admin = FALSE) {
        $where = [
            'is_published' => 1,
            'is_deleted' => 0
        ];

        if(!$is_admin) {
            $where = array_merge($where, [
                'level' => '2'
            ]);
        }

        return $this->db->select('*')
            ->from($this->table)
            ->where($where)
            ->order_by('id', 'desc')
            ->limit(5)
            ->get()
            ->result_array();
    }

    function getLast30DaysPerDay($begin) {
        return $this->db->select('DATE_FORMAT(created_at, "%Y-%m-%d") as date, count(id) as count')
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

    function getLastNumberArsip() {
        return $this->db->select('nomor')
            ->from($this->table)
            ->where('is_deleted', 0)
            ->where('nomor is not null', null, false)
            ->order_by('nomor', 'desc')
            ->limit(1)
            ->get()
            ->row_array();
    }
}