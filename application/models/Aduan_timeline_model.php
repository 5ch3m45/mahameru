<?php

class Aduan_timeline_model extends CI_Model
{
    protected $table = 'tbl_aduan_timeline';

    function getAllByAduanID($aduanID) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('aduan_id', $aduanID)
            ->where('is_deleted', 0)
            ->order_by('status', 'asc')
            ->get()
            ->result_array();
    }

    function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function getLastStatusAduanByAduanID($aduanID) {
        return $this->db->select('*')
            ->from($this->table)
            ->where('aduan_id', $aduanID)
            ->where('is_deleted', 0)
            ->order_by('status', 'desc')
            ->limit(1)
            ->get()
            ->row_array();
    }

    function getOneWhere($where) {
        return $this->db->select('*')
            ->from($this->table)
            ->where($where)
            ->where('is_deleted', 0)
            ->limit(1)
            ->get()
            ->row_array();
    }

    function destroy($id) {
        return $this->db->update($this->table, [
            'is_deleted' => 1,
            'deleted_at' => date('c')
        ], [
            'id' => $id
        ]);
    }
}