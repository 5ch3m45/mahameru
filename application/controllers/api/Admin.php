<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model([
            'admin_model',
            'arsip_model'
        ]);
        $this->load->library([
            'form_validation'
        ]);
        $this->lang->load('auth');
        $this->load->helper('string');

    }

	public function index() {
        $page = $this->input->get('page', TRUE);

        // validasi page start
        $page = preg_replace('/[^0-9]/i', '', $page);
        $page = (int)$page;
        if(!$page) {
            $page = 1;
        }
        // validasi page end

        // set offset 
        $offset = PERPAGE * ($page -1);

        // get admin
        $admins = $this->db->select('u.id, u.name, u.email, u.image, DATE_FORMAT(u.last_login, "%e %b %Y %H:%i:%s") as last_login, count(a.id) as arsip_count')
            ->from('users u')
            ->join('(SELECT id, admin_id, is_deleted FROM tbl_arsip WHERE is_deleted = 0) a', 'a.admin_id = u.id', 'left')
            ->where('u.active', 1)
            ->limit(PERPAGE, $offset)
            ->group_by('u.id')
            ->get()
            ->result_array();

        // get total_page info
        $records = $this->db->select('count(id) as record')
            ->from('users')
            ->get()
            ->row_array();
        $total_page = ceil($records['record'] / PERPAGE);

		return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $admins,
                'current_page' => (int)$page,
                'total_page' => (int)$total_page
            ]));
	}


    

}
