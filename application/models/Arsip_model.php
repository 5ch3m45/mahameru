<?php

class Arsip_model extends CI_Model
{
    protected $table = 'tbl_arsip';

    function create($data) {
        $this->db->insert('tbl_arsip', $data);
        return $this->db->insert_id();
    }

    function getArsipPublic($page, $search, $date, $sort) {
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal')
            ->from($this->table)
            ->where('level', 2)
            ->where('status', 2);

        if($search) {
            $query = $query->group_start()
                ->where('informasi LIKE', '%'.$search.'%')
                ->or_where('nomor LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->group_end();
        }

        if($date) {
            if($date['start']) {
                $query = $query->where('tanggal >=', $date['start']);
            }
            if($date['end']) {
                $query = $query->where('tanggal <=', $date['end']);
            }
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

    function countArsipPublic($search, $date) {
        $query = $this->db->select('id, informasi, klasifikasi_id, nomor, pencipta, tanggal')
            ->from($this->table)
            ->where('level', 2)
            ->where('status', 2);

        if($search) {
            $query = $query->group_start()
                ->where('informasi LIKE', '%'.$search.'%')
                ->or_where('nomor LIKE', '%'.$search.'%')
                ->or_where('pencipta LIKE', '%'.$search.'%')
                ->group_end();
        }
        if($date) {
            if($date['start']) {
                $query = $query->where('tanggal >=', $date['start']);
            }
            if($date['end']) {
                $query = $query->where('tanggal <=', $date['end']);
            }
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

        if(in_array($sort, ['terbaru', 'terlama', 'nomoraz', 'nomorza', 'terpopuler'])) {
            if($sort == 'terbaru') {
                $query = $query->order_by('tanggal', 'desc');
            }
            if($sort == 'terlama') {
                $query = $query->order_by('tanggal', 'asc');
            }
            if($sort == 'terpopuler') {
                $query = $query->order_by('viewers', 'desc');
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

    function addTotalViewers($arsip_id, $viewers) {
        return $this->db->where('id', $arsip_id)
            ->update($this->table, [
                'viewers' => $viewers,
                'last_viewer_update' => time()
            ]);
    }

    function getAllHistoricalPublication($start_date, $end_date) {
        return $this->db->select('DATE_FORMAT(created_at, "%Y-%m-%d") as date, count(id) as count')
            ->from('tbl_arsip')
            ->where('updated_at >=', $start_date)
            ->where('updated_at <=', $end_date)
            ->where('status', 2)
            ->group_by('date')
            ->get()
            ->result_array();
    }

    function getTopArsip($limit) {
        return $this->db->select('id, nomor, informasi, tanggal, viewers, pencipta')
            ->from('tbl_arsip')
            ->order_by('viewers', 'desc')
            ->limit($limit)
            ->get()
            ->result_array();
    }

    function totalViewers()
    {
        return $this->db->select('sum(viewers) as total')
            ->from('tbl_arsip')
            ->get()
            ->row_array();
    }
}