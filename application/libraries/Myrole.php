<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myrole
{
    protected $CI;
    protected $userID;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->userID = $this->CI->session->userdata('user_id');
    }

    public function asArray() {
        $roles = $this->CI->db->select('g.name')
            ->from('users_groups ug')
            ->join('groups g', 'g.id = ug.group_id', 'left')
            ->where('ug.user_id', $this->userID)
            ->get()
            ->result_array();
        $result = [];
        foreach ($roles as $key => $value) {
            array_push($result, $value['name']);
        }
        return $result;
    }

    public function is($role, $show404 = FALSE) {
        $result = $this->CI->db->select('ug.id, ug.user_id, g.name')
            ->from('users_groups ug')
            ->join('groups g', 'g.id = ug.group_id', 'left')
            ->where('ug.user_id', $this->userID)
            ->where('g.name', $role)
            ->limit(1)
            ->get()
            ->row_array();

        if($show404 && !$result) return show_404();
        return $result;
    }

    public function are($roles, $show404 = FALSE) {
        $result = $this->CI->db->select('ug.id, ug.user_id, g.name')
            ->from('users_groups ug')
            ->join('groups g', 'g.id = ug.group_id', 'left')
            ->where('ug.user_id', $this->userID)
            ->where_in('g.name', $roles)
            ->limit(1)
            ->get()
            ->row_array();

        if($show404 && !$result) return show_404();
        return $result;
    }

    public function isnot($role, $show404 = FALSE) {
        $result = $this->CI->db->select('ug.id, ug.user_id, g.name')
            ->from('users_groups ug')
            ->join('groups g', 'g.id = ug.group_id', 'left')
            ->where('ug.user_id', $this->userID)
            ->where('g.name', $role)
            ->limit(1)
            ->get()
            ->row_array();
        
        if($show404 && $result) return show_404();
        return !$result;
    }

    public function arenot($roles, $show404 = FALSE) {
        $result = $this->CI->db->select('ug.id, ug.user_id, g.name')
            ->from('users_groups ug')
            ->join('groups g', 'g.id = ug.group_id', 'left')
            ->where('ug.user_id', $this->userID)
            ->where_in('g.name', $roles)
            ->limit(1)
            ->get()
            ->row_array();

        if($show404 && $result) return show_404();
        return !$result;
    }
}