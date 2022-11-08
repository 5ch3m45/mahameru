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

    function getArsipDashboard($admin_role, $page, $search, $level, $status, $sort) {
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal, level, viewers, status, admin_id')
            ->from($this->table);

        if($search) {
            $query = $query->group_start()
                ->where('informasi LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->or_where('tanggal LIKE', '%'.$search.'%')
                ->group_end();
        }

        if($status && in_array($status, ['draft', 'publikasi', 'dihapus'])) {
            if($status == 'draft') {
                $query = $query->where('status', 1);
            }
            if($status == 'publikasi') {
                $query = $query->where('status', 2);
            }
            if($status == 'dihapus') {
                $query = $query->where('status', 3);
            }
		} else {
            $query = $query->where('status <>', 3);
        }

        if($admin_role == 'arsip_semua') {
            if($level && in_array($level, ['publik', 'rahasia'])) {
                if($level == 'rahasia') {
                    $query = $query->where('level', 1);
                }
                if($level == 'publik') {
                    $query = $query->where('level', 2);
                }
            }
        } else {
            $query = $query->where('level', 2);
        }

        if(in_array($sort, ['terbaru', 'terlama', 'nomoraz', 'nomorza'])) {
            if($sort == 'terbaru') {
                $query = $query->order_by('tanggal', 'desc');
            }
            if($sort == 'terlama') {
                $query = $query->order_by('tanggal', 'asc');
            }
            if($sort == 'nomoraz') {
                $query = $query->order_by('nomor', 'asc');
            }
            if($sort == 'nomorza') {
                $query = $query->order_by('nomor', 'desc');
            }
        } else {
            $query = $query->order_by('tanggal', 'desc');
        }

        $offset = PERPAGE * ($page -1);
        return $query->limit(PERPAGE, $offset)
            ->get()
            ->result_array();
    }

    function countArsipDashboard($admin_role, $search, $level, $status) {
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal, level, viewers, status, admin_id')
            ->from($this->table);

        if($search) {
            $query = $query->group_start()
                ->where('informasi LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->or_where('tanggal LIKE', '%'.$search.'%')
                ->group_end();
        }

        if($status && in_array($status, ['draft', 'publikasi', 'dihapus'])) {
            if($status == 'draft') {
                $query = $query->where('status', 1);
            }
            if($status == 'publikasi') {
                $query = $query->where('status', 2);
            }
            if($status == 'dihapus') {
                $query = $query->where('status', 3);
            }
		} else {
            $query = $query->where('status <>', 3);
        }

        if($admin_role == 'arsip_semua') {
            if($level && in_array($level, ['publik', 'rahasia'])) {
                if($level == 'rahasia') {
                    $query = $query->where('level', 1);
                }
                if($level == 'publik') {
                    $query = $query->where('level', 2);
                }
            }
        } else {
            $query = $query->where('level', 2);
        }

        return $query->count_all_results();
    }
}