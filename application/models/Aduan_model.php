<?php

class Aduan_model extends CI_Model
{
    protected $table = 'tbl_aduan';

    function getOneByKode($kode) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('kode', $kode)
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

    function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function getPaginated($page) {
        $offset = 10 * ($page -1);
        return $this->db->select('*')
            ->from($this->table)
            ->order_by('id', 'desc')
            ->limit(10, $offset)
            ->get()
            ->result_array();
    }

    function delete($id) {
        return $this->delete($this->table, ['id', $id]);
    }

    function getAduanDashboard($page, $search, $status, $sort) {
        $offset = PERPAGE * ($page -1);
        $query = $this->db->select('*')
            ->from('tbl_aduan')
            ->where('is_deleted', 0);

		// search query
		if($search) {
			$query = $query->group_start()
				->where('kode LIKE', '%'.$search.'%')
				->or_where('nama LIKE', '%'.$search.'%')
				->or_where('email LIKE', '%'.$search.'%')
				->group_end();
		}

		// status
		if($status && in_array($status, [1, 2, 3, 4])) {
			$query = $query->where('status', $status);
		}

		// sort
		if($sort && in_array($sort, ['terbaru', 'terlama'])) {
			if($sort == 'terbaru') {
				$query = $query->order_by('created_at', 'desc');
			} else {
				$query = $query->order_by('created_at', 'asc');
			}
		} else {
			$query = $query->order_by('created_at', 'desc');
		}
		
        return $query->limit(PERPAGE, $offset)
            ->get()
            ->result_array();
    }

    function countAduanDashboard($search, $status) {
        $query = $this->db->select('*')
            ->from('tbl_aduan')
            ->where('is_deleted', 0);

		// search query
		if($search) {
			$query = $query->group_start()
				->where('kode LIKE', '%'.$search.'%')
				->or_where('nama LIKE', '%'.$search.'%')
				->or_where('email LIKE', '%'.$search.'%')
				->group_end();
		}

		// status
		if($status && in_array($status, [1, 2, 3, 4])) {
			$query = $query->where('status', $status);
		}
		
        return $query->count_all_results();
    }
}