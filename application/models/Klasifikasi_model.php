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

    function getOneByID($id) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneByIDPublic($id) {
        return $this->db->select('kode, nama')
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
            ->order_by('kode', 'asc')
            ->get()
            ->result_array();
    }

    function getAll() {
        return $this->db->select('*')
            ->from($this->table)
            ->order_by('kode', 'asc')
            ->get()
            ->result_array();
    }

    function getTop5() {
        return $this->db->select('tbl_klasifikasi.id, tbl_klasifikasi.kode, tbl_klasifikasi.nama, count(tbl_arsip.id) as arsip_count')
            ->from($this->table)
            ->join('tbl_arsip', 'tbl_arsip.klasifikasi_id = tbl_klasifikasi.id', 'left')
            ->where('tbl_arsip.is_published', 1)
            ->where('tbl_arsip.is_deleted', 0)
            ->group_by('tbl_klasifikasi.id')
            ->order_by('arsip_count', 'desc')
            ->limit(5)
            ->get()
            ->result_array();
    }

    function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    function getKlasifikasiDashboard($page, $search, $sort) {
        $query = $this->db->select('k.id, k.kode, k.nama, k.deskripsi, k.updated_at')
            ->from('tbl_klasifikasi k');

        if($search) {
            $query = $query->where('kode LIKE', '%'.$search.'%')
                ->or_where('nama LIKE', '%'.$search.'%');
        }

        $offset = PERPAGE * ($page -1);
        $query = $query->limit(PERPAGE, $offset)
			->group_by('k.id');

        if($sort == 'nama') {
            $query = $query->order_by('k.nama', 'asc');
        } else if($sort == 'arsip-terbanyak') {
            $query = $query->order_by('arsip_count', 'desc');
        } else if($sort == 'arsip-tersedikit') {
            $query = $query->order_by('arsip_count', 'asc');
        } else {
            $query = $query->order_by('kode', 'asc');
        }

        return $query->where('k.is_deleted', 0)
            ->get()
            ->result_array();
    }

    function countKlasifikasiDashboard($search) {
        $query = $this->db->select('k.id, k.kode, k.nama, k.deskripsi, k.updated_at')
            ->from('tbl_klasifikasi k');

        if($search) {
            $query = $query->where('kode LIKE', '%'.$search.'%')
                ->or_where('nama LIKE', '%'.$search.'%');
        }

        return $query->count_all_results();
    }
}