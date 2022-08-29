<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model([
			'arsip_model',
			'lampiran_model',
			'klasifikasi_model'
		]);
	}
	public function index() {
		$this->load->view('admin/arsip_index');
	}

	public function create() {
		$this->load->model('arsip_model');
		$arsip_id = $this->arsip_model->create([
			'admin_id' => 1,
			'created_at' => date('c'),
			'updated_at' => date('c')
		]);
		redirect(base_url('admin/arsip/detail/'.$arsip_id));
	}

	public function detail($id) {
		$this->load->model('arsip_model');

		$arsip = $this->arsip_model->first($id);
		
		if(!$arsip) {
			echo 'Not found';
			die();
		}
		$klasifikasis = $this->klasifikasi_model->getAll();
		$lampirans = $this->lampiran_model->getBatchByArsip($arsip['id']);

		$this->load->view('admin/arsip_detail', compact('arsip', 'klasifikasis', 'lampirans'));
	}

	public function do_upload() {
		$this->load->helper('string');

        $config['upload_path']   = APPPATH.'/../assets/uploads';
        $config['allowed_types'] = '*';
		$config['file_name']     = random_string('numeric', 6).'-'.$_FILES['file']['name'];
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            return $this->output->set_output(
				json_encode([
					'success' => false,
					'data' => $error,
				]));
        } else {
            $data = array('upload_data' => $this->upload->data());

            return $this->output->set_output(
				json_encode([
					'success' => true,
					'data' => $this->upload->data('file_name'),
				]));
        }
    }
}
