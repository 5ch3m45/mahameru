<?php

class Arsip_model extends CI_Model
{
    protected $table = 'tbl_arsip';

    function create($data) {
        $this->db->insert('tbl_arsip', $data);
        return $this->db->insert_id();
    }

    function getArsipPublic($page, $search, $sort) {
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal')
            ->from($this->table)
            ->where('level', 2)
            ->where('status', 2);

        if($search) {
            $query = $query->group_start()
                ->where('informasi LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->or_where('tanggal LIKE', '%'.$search.'%')
                ->group_end();
        }

        if($sort) {
            if($sort == 'terlama') {
                $query = $query->order_by('tanggal', 'asc');
            } else {
                $query = $query->order_by('tanggal', 'desc');
            }
        } else {
            $query = $query->order_by('tanggal', 'desc');
        }

        $offset = PERPAGE * ($page -1);
        return $query->limit(PERPAGE, $offset)
            ->get()
            ->result_array();
    }

    function countArsipPublic($search) {
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal')
            ->from($this->table)
            ->where('level', 2)
            ->where('status', 2);

        if($search) {
            $query = $query->group_start()
                ->where('informasi LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->or_where('tanggal LIKE', '%'.$search.'%')
                ->group_end();
        }

        return $query->count_all_results();
    }
}