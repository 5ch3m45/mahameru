<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    function __construct() {
        parent::__construct();

        // $this->load->library('form_validation');
        $this->load->model([
            'admin_model',
            'arsip_model'
        ]);

    }

	public function index() {
        $page = $this->input->get('page', TRUE);

        if(!$page) {
            $page = 1;
        }

        if(!is_int((int)$page)) {
            $page = 1;
        }

        $admins = $this->admin_model->getPaginated($page);
        foreach ($admins as $key => $admin) {
            $admins[$key]['arsip_count'] = $this->arsip_model->countArsipByAdmin($admin['id']);
        }
		return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'data' => $admins
            ]));
	}
    
    public function show($id) {
        if(!is_int((int)$id)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'messsage' => 'ID Admin tidak valid'
                ]));
        }

        $admin = $this->admin_model->getOneByID((int)$id);

        if(!$admin) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'messsage' => 'Admin tidak ditemukan'
                ]));
        }

        $admin['arsip_count'] = $this->arsip_model->countArsipByAdmin($admin['id']);
        $admin['last_login'] = $admin['last_login'] ? date_format(date_create($admin['last_login']), 'd-m-Y H:i:s') : date('d-m-Y H:i:s');

        return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $admin
                ]));
    }
}
