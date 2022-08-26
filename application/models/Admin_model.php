<?php

class Admin_model extends CI_Model
{
    function getFirst($id) {
        return $this->db->select('*')
            ->from('tbl_admin')
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }
}