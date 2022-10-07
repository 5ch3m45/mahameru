<?php

class Group_model extends CI_Model
{
    protected $table = 'users_groups';

    function getByUserID($user_id) {
        return $this->db->select('g.name, g.description')
            ->from('users_groups ug')
            ->where('ug.user_id', $user_id)
            ->join('groups g', 'ug.group_id = g.id', 'left')
            ->get()
            ->result_array();
    }
}